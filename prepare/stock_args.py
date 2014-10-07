#!/usr/bin/python

from db_util import get_shares, get_daily_args

def get_value_by_arg_name(stock_no, arg_name, date_str, period='day'):
    if not ashare or not args: return None

    if arg_name == '1':
        if period == 'day':
            ashare = get_shares(stock_no)
            # open, close, high, low, volume, turnover
            args = get_daily_args(stock_no, date_str)
            diff = args[2] - args[0] 
            return diff
