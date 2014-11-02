#!/usr/bin/python

from db_util import get_shares, get_daily_args

def get_stock_features(stock_no, time_str, period='day'):
    if period == 'day':
        args = get_daily_args(stock_no, time_str)
        ashare = get_shares(stock_no, time_str)
        if not args or not ashare: 
            return []

        v_open, v_close, v_high, v_low, v_volume, v_turnover = [float(v) for v in args]
        ashare = float(ashare)
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
        features.append( v_low - v_close )
        #elif arg_name == '8': # above_volume - average_above_volume
        features.append( 0 )
        #elif arg_name == '9': # under_volume - last_under_volume
        features.append( 0 )
        #elif arg_name == '10': # under_volume - average_under_volume
        features.append( 0 )
        #elif arg_name == '11': # above_turnover - last_above_turnover
        features.append( 0 )
        #elif arg_name == '12': # above_turnover - average_above_turnover
        features.append( 0 )
        #elif arg_name == '13': # under_turnover - last_under_turnover
        features.append( 0 )
        #elif arg_name == '14': # under_turnover - average_under_turnover
        features.append( 0 )
        #elif arg_name == '15': # up_rate = (close - open) / open; down_rate = (open - close) / open
        features.append( (v_close - v_open) / v_open )
        #elif arg_name == '16': # up_rate / average_up_rate; down_rate / average_down_rate 
        features.append( 0 )
        #elif arg_name == '17': # up_amp_rate = (high - open) / open; down_amp_rage = (open - low) / open 
        features.append( (v_high - v_open) / v_open )
        features.append( (v_open - v_low) / v_open )
        #elif arg_name == '18': # up_amp_rate / average_up_amp_rage; down_amp_rage / average_down_amp_rate
        features.append( 0 )
        #elif arg_name == '19': # turnover_rate = volume / ashare; A = average_volume / average_turnover_rate; B = volume / turnover_rage; B / A
        features.append( 0 )
        #elif arg_name == '20': # A = average_turnover / (ashare * average_close); B = turnover / (ashare * close); B / A
        features.append( 0 )

        return features
    else:
        return []

def test():
    print get_stock_features(600000, '2014-09-12')

if __name__ == '__main__':
    test()
