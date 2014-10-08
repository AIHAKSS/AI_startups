#!/usr/bin/python

from db_util import get_shares, get_daily_args

def get_value_by_arg_name(stock_no, arg_name, date_str, period='day'):
    if not ashare or not args: return None

    if arg_name == '1': # high - open
        if period == 'day':
            # ashare
            ashare = get_shares(stock_no)
            # open, close, high, low, volume, turnover
            args = get_daily_args(stock_no, date_str)
            diff = args[2] - args[0] 
            return diff
    elif arg_name == '2': # high - low
        pass 
    elif arg_name == '3': # high - close
        pass
    elif arg_name == '4': # open - low
        pass
    elif arg_name == '5': # open - close
        pass
    elif arg_name == '6': # low - close
        pass
    elif arg_name == '7': # above_volume - last_above_volume
        pass
    elif arg_name == '8': # above_volume - average_above_volume
        pass
    elif arg_name == '9': # under_volume - last_under_volume
        pass
    elif arg_name == '10': # under_volume - average_under_volume
        pass
    elif arg_name == '11': # above_turnover - last_above_turnover
        pass
    elif arg_name == '12': # above_turnover - average_above_turnover
        pass
    elif arg_name == '13': # under_turnover - last_under_turnover
        pass
    elif arg_name == '14': # under_turnover - average_under_turnover
        pass
    elif arg_name == '15': # up_rate = (close - open) / open; down_rate = (open - close) / open
        pass
    elif arg_name == '16': # up_rate / average_up_rate; down_rate / average_down_rate 
        pass
    elif arg_name == '17': # up_amp_rate = (high - open) / open; down_amp_rage = (open - low) / open 
        pass
    elif arg_name == '18': # up_amp_rate / average_up_amp_rage; down_amp_rage / average_down_amp_rate
        pass
    elif arg_name == '19': # turnover_rate = volume / ashare; A = average_volume / average_turnover_rate; B = volume / turnover_rage; B / A
        pass
    elif arg_name == '20': # A = average_turnover / (ashare * average_close); B = turnover / (ashare * close); B / A
        pass


