#!/usr/bin/python

import MySQLdb  #http://mysql-python.sourceforge.net/MySQLdb.html#mysqldb
import requests
from bs4 import BeautifulSoup

def download_meta_info(stock_no, date_str, last_days):
    pass

def insert_meta_info(stock_no, rows):
    pass

def get_metas(stock_no):
    #market, category
    pass
'''
    db_ = MySQLdb.connect(host="localhost", port=3306, user="xkx", passwd="xkx", db="xkx")
    cursor_ = db_.cursor()
    sql = "SELECT ashares FROM xkx.tb_structinfo where stockno='%s' and date<='%s' order by date desc limit 1;" % (stock_no, date_str)
    rows = []
    try:
        cursor_.execute(sql)
        results = cursor_.fetchall()
        for row in results:
            rows.append(row)
        cursor_.close()
    except Exception, e:
        print repr(e)
    if rows:
        return rows[0]
    else:
        rows = download_meta_info(stock_no, date_str, last_days):
        insert_meta_info(stock_no, rows)
    return 0 
'''


def test():
    print get_metas('600000')


if __name__ == '__main__':
    test()
