#!/usr/bin/python

import MySQLdb  #http://mysql-python.sourceforge.net/MySQLdb.html#mysqldb
import requests
from bs4 import BeautifulSoup

def download_share_info(stock_no, date_str, last_days):
    return ''

def insert_share_info(stock_no, rows):
    pass

def get_shares(stock_no, date_str):
    #ashares

    db_ = MySQLdb.connect(host="localhost", port=3306, user="xkx", passwd="xkx", db="xkx")
    cursor_ = db_.cursor()
    sql = "SELECT ashares FROM xkx.tb_structinfo where stockno='%s' and date<='%s' order by date desc limit 1;" % (stock_no, date_str)
    row = []
    try:
        cursor_.execute(sql)
        rows = cursor_.fetchall()
        for r in rows:
            row = r
            break
        cursor_.close()
        db_.close()
    except Exception, e:
        print repr(e)
    if row:
        return row[0]
    else:
        row = download_share_info(stock_no, date_str, last_days)
        if row:
            insert_share_info(stock_no, row)
    return 0 


def test():
    print get_shares('600000', '2014-09-12')


if __name__ == '__main__':
    test()
