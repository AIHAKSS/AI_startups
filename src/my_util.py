#!/usr/bin/python

import time

def date_to_time(date_str):
    arr = [int(v) for v in date_str.split('-')]
    return time.mktime(arr + [0]*6)
    
def date_to_int(date_str):
    return int(date_str.replace('-', ''))

def int_to_date(int_date):
    s = str(int_date)
    return '%s-%s-%s' % (s[:4], s[4:6], s[6:])

def depack_date_str(date_str):
    lt = time.localtime(date_to_time(date_str))
    season = (lt.tm_mon - 1) / 3 + 1
    return [lt.tm_year, season, lt.tm_mon, lt.tm_mday, lt.tm_wday]

def date_delta(date_str, delta=0):
    t = date_to_time(date_str)
    t2 = t + delta * 86400
    lt2 = time.localtime(t2)
    return '%04d-%02d-%02d' % (lt2.tm_year, lt2.tm_mon, lt2.tm_mday)


def test():
    print depack_date_str('2012-09-12')
    print date_delta('2012-09-12', 58)
    print date_delta('2012-09-12', -58)
    print int_to_date(20120902)

if __name__ == '__main__':
    test()
