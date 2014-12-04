#!/usr/bin/python

import MySQLdb
import requests
from bs4 import BeautifulSoup

def download_price_details(stock_no, date_str):
    if len(stock_no) == 6 and stock_no[0]=='6':
        symbol = 'sh' + stock_no 
    elif len(stock_no) == 6 and stock_no[0]=='0':
        symbol = 'sz' + stock_no 
    else:
        symbol = stock_no 
    url = 'http://market.finance.sina.com.cn/pricehis.php?symbol=%s&startdate=%s&enddate=%s' % (symbol, date_str, date_str)
    rows = []
    headers = {}
    headers['User-Agent'] = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safari/537.36'
    headers['Accept-Language'] = 'en-US,en;q=0.8,zh-CN;q=0.6,zh;q=0.4'
    raw_html = requests.get(url, headers=headers, timeout=30.).content    
    if not raw_html: return [] 
    soup = BeautifulSoup(raw_html)
    for v in soup.select('table#datalist tr'):
        row = []
        for v2 in v.select('td'):
            row.append( v2.text.strip().encode('utf-8') )
        if len(row) == 3 and row[-1][-1] == '%':
            rows.append(row[:2])
    return rows

def insert_price_details(stock_no, date_str, rows):
    db_ = MySQLdb.connect(host="localhost", port=3306, user="xkx", passwd="xkx", db="xkx")
    cursor_ = db_.cursor()
    try:
        for row in rows:
            sql = "REPLACE INTO xkx.tb_pricedetail(`stockno`, `date`, `price`, `volume`) \
                    VALUES ('%s', %s, %s,  %s) \
                    ;" % (stock_no, date_str.replace('-',''), row[0], row[1])
            cursor_.execute(sql)
            db_.commit()
        cursor_.close()
        db_.close()
    except Exception, e:
        print repr(e)

def get_price_details(stock_no, date_str):
    #`price`, `volume`

    db_ = MySQLdb.connect(host="localhost", port=3306, user="xkx", passwd="xkx", db="xkx")
    cursor_ = db_.cursor()
    sql = "SELECT `price`, `volume` FROM xkx.tb_pricedetail where stockno='%s' and date='%s';" % (stock_no, date_str.replace('-',''))
    rows = []
    try:
        cursor_.execute(sql)
        results = cursor_.fetchall()
        for row in results:
            rows.append(row)     
        cursor_.close()
        db_.close()
    except Exception, e:
        print repr(e)
    if rows:
        return rows 
    else:
        rows = download_price_details(stock_no, date_str)
        insert_price_details(stock_no, date_str, rows)
        return rows

def get_up_down_volume(stock_no, date_str, open_price):
    #up_volume, down_volume

    details = get_price_details(stock_no, date_str)
    up_volume, down_volume = 0, 0
    for price, volume in details: 
        if price > open_price: up_volume += volume
        elif price < open_price: down_volume += volume
    return up_volume, down_volume
    

def test():
    print get_price_details('600000', '2014-11-14')
    print  get_up_down_volume('600000', '2014-11-14', 10.88)


if __name__ == '__main__':
    test()

