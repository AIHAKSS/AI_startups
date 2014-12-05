#!/usr/bin/python

import my_util
from market_log import get_daily_prices
from feature_db import calc_period_variable

def get_dynamic_ratio(stock_no, date_str):
    price_list = get_daily_prices(stock_no, date_str, date_str)
    price = 0
    if price_list:
        price price_list[0][1]
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

def equations(stock_no, date_str):
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
    if not ratio or not variables_list:
        return []
    rs = []
    rs.append( vs[0][0] ) 


def test():
    pass


if __name__ == '__main__':
    test()
