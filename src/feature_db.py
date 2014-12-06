#!/usr/bin/python

import MySQLdb
import math
import json
from share_info import get_shares
from market_log import get_daily_prices
from price_detail import get_up_down
import my_util

avg_period_days = 30
avg_oldest_date = 20141001
variable_period = 30

def calc_period_variable(stock_no, date_str, period=variable_period):
    history_list = []
    for i in range(0, period):
        ds = my_util.date_delta(date_str, -i)
        if my_util.date_to_int(ds) < avg_oldest_date: 
            break
        history = get_day_features(stock_no, ds)
        if history:
            history_list.append(history)
    if not history_list:
        return []
    variables_list = []
    for i in range(len(history_list[0])):
        v_list = [history[i] for history in history_list]
        variables_list.append( (max(v_list), min(v_list), sum(v_list)/len(v_list)) )
    return variables_list


def insert_day_features(stock_no, date_str, row):
    db_ = MySQLdb.connect(host="localhost", port=3306, user="xkx", passwd="xkx", db="xkx")
    cursor_ = db_.cursor()
    try:
        sql = "REPLACE INTO xkx.tb_midvalue(`stockno`, `date`, `features`) \
                    VALUES ('%s', %s, '%s');" % (stock_no, date_str.replace('-',''), json.dumps(row))
        cursor_.execute(sql)
        db_.commit()
        cursor_.close()
        db_.close()
    except Exception, e:
        print repr(e)

def get_next_features(stock_no, date_str):
    db_ = MySQLdb.connect(host="localhost", port=3306, user="xkx", passwd="xkx", db="xkx")
    cursor_ = db_.cursor()
    sql = "SELECT `features` FROM xkx.tb_midvalue where stockno='%s' and date>'%s' order by date limit 1;" % (stock_no, date_str.replace('-',''))
    row = []
    try:
        cursor_.execute(sql)
        ret = cursor_.fetchone()
        if ret:
            row = json.loads(ret[0])
        cursor_.close()
        db_.close()
    except Exception, e:
        print repr(e)
    return row

def get_day_features(stock_no, date_str, update=False):
    if update:
        row = calc_day_features(stock_no, date_str, avg_period_days)
        if row:
            insert_day_features(stock_no, date_str, row)
        return row

    db_ = MySQLdb.connect(host="localhost", port=3306, user="xkx", passwd="xkx", db="xkx")
    cursor_ = db_.cursor()
    sql = "SELECT `features` FROM xkx.tb_midvalue where stockno='%s' and date='%s';" % (stock_no, date_str.replace('-',''))
    row = []
    try:
        cursor_.execute(sql)
        ret = cursor_.fetchone()
        if ret:
            row = json.loads(ret[0])
        cursor_.close()
        db_.close()
    except Exception, e:
        print repr(e)
    if not row:
        row2 = get_next_features(stock_no, date_str)
        if row2: 
            return []
        row = calc_day_features(stock_no, date_str, avg_period_days)
        if row:
            insert_day_features(stock_no, date_str, row)
    return row

def calc_day_features(stock_no, date_str, past=avg_period_days):
    print 'calc_day_features', stock_no, date_str, avg_period_days
    ashare = int(get_shares(stock_no, date_str))
    if not ashare:
        return []

    price_list = get_daily_prices(stock_no, my_util.date_delta(date_str, -past), date_str)
    if price_list[0][0] != my_util.date_to_int(date_str):
        return []
    for i, price in enumerate(price_list):
        ds = my_util.int_to_date(price[0])
        up_volume, up_to, down_volume, down_to = get_up_down(stock_no, ds, float(price[1]))
        price_list[i][0] = ds
        price_list[i].extend([up_volume, up_to, down_volume, down_to])

    history_list = []
    for i in range(1, past+1):
        ds = my_util.date_delta(date_str, -i)
        if my_util.date_to_int(ds) < avg_oldest_date: 
            break
        history = get_day_features(stock_no, ds)
        if history:
            history_list.append(history)

    v_open, v_close, v_high, v_low, v_volume, v_turnover, up_v, up_to, down_v, down_to = [float(v) for v in price_list[0][1:]]

    features = []    

    #if arg_name == '1': # high - open
    features.append( v_high - v_open )
    #elif arg_name == '2': # high - low
    features.append( v_high - v_low )
    #elif arg_name == '3': # high - close
    features.append( v_high - v_close )
    #elif arg_name == '4': # open - low
    features.append( v_open - v_low )
    #elif arg_name == '5': # open - close
    features.append( v_open - v_close )
    #elif arg_name == '6': # low - close
    features.append( v_low - v_close )
    #elif arg_name == '7': # above_volume - last_above_volume
    if len(price_list) > 1: features.append( up_v - float(price_list[1][6]) )
    else: features.append( 0 )
    #elif arg_name == '8': # above_volume - average_above_volume
    avg_up = sum([float(v[6]) for v in price_list])/sum([1 for v in price_list] + [0.1])
    features.append( up_v - avg_up )
    #elif arg_name == '9': # under_volume - last_under_volume
    if len(price_list) > 1: features.append( down_v - float(price_list[1][8]) )
    else: features.append( 0 )
    #elif arg_name == '10': # under_volume - average_under_volume
    avg_down = sum([float(v[8]) for v in price_list])/sum([1 for v in price_list] + [0.1])
    features.append( down_v - avg_down )
    #elif arg_name == '11': # above_turnover - last_above_turnover
    if len(price_list) > 1: features.append( up_to - float(price_list[1][7]) )
    else: features.append( 0 )
    #elif arg_name == '12': # above_turnover - average_above_turnover
    avg_upto = sum([float(v[7]) for v in price_list])/sum([1 for v in price_list] + [0.1])
    features.append( up_to - avg_upto )
    #elif arg_name == '13': # under_turnover - last_under_turnover
    if len(price_list) > 1: features.append( down_to - float(price_list[1][9]) )
    else: features.append( 0 )
    #elif arg_name == '14': # under_turnover - average_under_turnover
    avg_downto = sum([float(v[9]) for v in price_list])/sum([1 for v in price_list] + [0.1])
    features.append( down_to - avg_downto )
    #elif arg_name == '15': # up_rate = (close - open) / open
    up_rate = (v_close - v_open) / v_open
    features.append( up_rate ) 
    #elif arg_name == '16': # down_rate = (open - close) / open
    down_rate = (v_open - v_close) / v_open
    features.append( down_rate ) 
    #elif arg_name == '17': # up_rate / average_up_rate
    avg_upr = sum([float(v[14]) for v in history_list if v[14] > 0]) / sum([1 for v in history_list if v[14] > 0] + [0.1])
    if avg_upr > 0: features.append( up_rate / avg_upr )
    else: features.append( 1 )
    #elif arg_name == '18': # down_rate / average_down_rate 
    avg_downr = sum([float(v[15]) for v in history_list if v[15] > 0]) / sum([1 for v in history_list if v[15] > 0] + [0.1])
    if avg_downr > 0: features.append( down_rate / avg_downr )
    else: features.append( 1 )
    #elif arg_name == '19': # up_amp_rate = (high - open) / open;
    up_amp_rate = (v_high - v_open) / v_open
    features.append( up_amp_rate )
    #elif arg_name == '20': # down_amp_rage = (open - low) / open 
    down_amp_rate = (v_open - v_low) / v_open
    features.append( down_amp_rate ) 
    #elif arg_name == '21': # up_amp_rate / average_up_amp_rage
    avg_upar = sum([float(v[20]) for v in history_list]) / sum([1 for v in history_list] + [0.1])
    if avg_upar > 0: features.append( up_amp_rate / avg_upar )
    else: features.append( 1 )
    #elif arg_name == '22': # down_amp_rage / average_down_amp_rate
    avg_downar = sum([float(v[21]) for v in history_list]) / sum([1 for v in history_list] + [0.1])
    if avg_downar > 0: features.append( down_amp_rate / avg_downar )
    else: features.append( 1 )
    #elif arg_name == '23': # turnover_rate = volume / ashare; A = volume / turnover_rage; B = average_volume / average_turnover_rate
    features.append( 1 )
    #elif arg_name == '24': # A = turnover / (ashare * close); B = average_turnover / (ashare * average_close)
    A = v_turnover / (ashare * v_close)
    avg_turnover = sum([float(v[5]) for v in price_list])/sum([1 for v in price_list])
    avg_close = sum([float(v[1]) for v in price_list])/sum([1 for v in price_list])
    B = avg_turnover / (ashare * avg_close)
    features.append( A / B ) 

    features = [math.fabs(v) for v in features]
    return features


def test():
    print get_day_features('600000', '2014-12-05')
    print get_next_features('600000', '2014-12-05')
    print get_next_features('600000', '2014-10-12')

    print calc_period_variable('600000', '2014-12-05')

if __name__ == '__main__':
    test()

