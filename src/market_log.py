#!/usr/bin/python
#coding: utf-8

import MySQLdb
import requests
from bs4 import BeautifulSoup
import my_util

def download_season_prices(stock_no, from_date_str, to_date_str):
    start_year, start_season = my_util.depack_date_str(from_date_str)[:2]
    to_year, to_season = my_util.depack_date_str(to_date_str)[:2]
    urls = []
    i = 0
    while True:
        year, season = start_year + (start_season+i-1)/4, (start_season+i-1)%4+1
        url = 'http://money.finance.sina.com.cn/corp/go.php/vMS_MarketHistory/stockid/600000.phtml?year=%s&jidu=%s' % (year, season)
        urls.append(url)
        if year>=to_year and season>=to_season:
            break
        i += 1
    rows = []
    headers = {}
    headers['User-Agent'] = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safari/537.36'
    headers['Accept-Language'] = 'en-US,en;q=0.8,zh-CN;q=0.6,zh;q=0.4'
    for url in urls:
        raw_html = requests.get(url, headers=headers, timeout=30.).content    
        if not raw_html: continue
        soup = BeautifulSoup(raw_html)
        for v in soup.select('table#FundHoldSharesTable tr'):
            row = []
            for v2 in v.select('div'):
                row.append( v2.text.strip().encode('utf-8') )
            #日期 开盘价 最高价 收盘价 最低价 交易量(股) 交易金额(元)
            if len(row) == 7 and row[-1].isdigit():
                #`date`, `open`, `close`, `high`, `low`, `volume`, `turnover`
                row2 = [row[0], row[1], row[3], row[2], row[4], row[5], row[6]]
                rows.append(row2)
    return rows

def insert_daily_prices(stock_no, rows):
    db_ = MySQLdb.connect(host="localhost", port=3306, user="xkx", passwd="xkx", db="xkx")
    cursor_ = db_.cursor()
    try:
        for row in rows:
            sql = "REPLACE INTO xkx.tb_marketlog(`stockno`, `date`, `open`, `close`, `high`, `low`, `volume`, `turnover`) \
                    VALUES ('%s', %s, '%s',  '%s', '%s', '%s', '%s', '%s') \
                    ;" % (stock_no, row[0].replace('-',''), row[1], row[2], row[3], row[4], row[5], row[6])
            cursor_.execute(sql)
            db_.commit()
        cursor_.close()
        db_.close()
    except Exception, e:
        print repr(e)

def get_daily_prices(stock_no, from_date_str, to_date_str):
    #`date`, `open`, `close`, `high`, `low`, `volume`, `turnover`
    print 'get_daily_prices', stock_no, from_date_str, to_date_str

    db_ = MySQLdb.connect(host="localhost", port=3306, user="xkx", passwd="xkx", db="xkx")
    cursor_ = db_.cursor()
    sql = "SELECT `date`, `open`, `close`, `high`, `low`, `volume`, `turnover` FROM xkx.tb_marketlog where stockno='%s' and date>='%s' and date<='%s' order by date desc;" % (stock_no, from_date_str.replace('-',''), to_date_str.replace('-',''))
    rows = []
    max_date = 0
    try:
        cursor_.execute(sql)
        results = cursor_.fetchall()
        for row in results:
            rows.append(list(row))     
            max_date = max(int(row[0]), max_date) 
        cursor_.close()
        db_.close()
    except Exception, e:
        print repr(e)
    if max_date == int(to_date_str.replace('-','')):
        return rows 
    else:
        rows = download_season_prices(stock_no, from_date_str, to_date_str)
        insert_daily_prices(stock_no, rows)
        return rows
    

def test():
    print get_daily_prices('600000', '2014-09-12', '2014-11-14')


if __name__ == '__main__':
    test()

