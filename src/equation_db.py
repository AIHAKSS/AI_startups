#!/usr/bin/python

import my_util
from market_log import get_daily_prices
from feature_db import calc_period_variable

def get_dynamic_ratio(stock_no, date_str):
    price_list = get_daily_prices(stock_no, date_str, date_str)
    price = 0
    if price_list:
        price = price_list[0][1]
    if price == 0: ratio = 0
    elif price <= 10: ratio = 10
    elif price <= 100: ratio = 100
    elif price <= 1000: ratio = 1000
    elif price <= 10000: ratio = 100000
    else: ratio = 1000000
    return ratio

def equation_base(stock_no, date_str):
    variables_list = calc_period_variable(stock_no, date_str)
    ratio = get_dynamic_ratio(stock_no, date_str)
    return variables_list, ratio

def equations(stock_no, date_str, eqa_no, idx_list):
    '''
    a+b1  
    a*[1+(b2/10000* (C2/(D2+F2)))]
    a*[1-(b3/10000* (C3/(D3+F3)))]
    a-b4
    a*(1+E1/10000)
    a+b6
    a*[1+(b7/10000* (C7/(D7+F7)))]
    a*[1-(b8/10000* (C8/(D8+F8)))]
    a-b9
    a*(1- E2/10000)
    '''

    vs, ratio = equation_base(stock_no, date_str)
    args = [vs[i][j] for i, j in idx_list]
    if not ratio or not vs or not args:
        return []
    print 'args:', args
    
    if eqa_no == 1:
        return args[0] + args[1]
    elif eqa_no == 2:
        if args[3] + args[4] <= 0: return 10000000000000
        else: return args[0] * (1 + (args[1] / ratio * (args[2] / (args[3] + args[4]))))
    elif eqa_no == 3:
        if args[3] + args[4] <= 0: return 10000000000000
        else: return args[0] * (1 - (args[1] / ratio * (args[2] / (args[3] + args[4]))))
    elif eqa_no == 4:
        return args[0] - args[1]
    elif eqa_no == 5:
        return args[0] * (1 + args[1] / ratio)
    elif eqa_no == 6:
        return args[0] + args[1]
    elif eqa_no == 7:
        if args[3] + args[4] <= 0: return 10000000000000
        else: return args[0] * (1 + (args[1] / ratio * (args[2] / (args[3] + args[4]))))
    elif eqa_no == 8:
        if args[3] + args[4] <= 0: return 10000000000000
        else: return args[0] * (1 - (args[1] / ratio * (args[2] / (args[3] + args[4]))))
    elif eqa_no == 9:
        return args[0] + args[1]
    elif eqa_no == 10:
        return args[0] * (1 - args[1] / ratio)
    else:
        return None


def test():
    print equations('600000', '2014-12-5', 1, [(0, 0), (1, 0)])
    print equations('600000', '2014-12-5', 2, [(0, 0), (1, 1), (2, 1), (3, 1), (4, 1)])
    print equations('600000', '2014-12-5', 3, [(0, 0), (1, 2), (2, 2), (3, 2), (4, 2)])


if __name__ == '__main__':
    test()

