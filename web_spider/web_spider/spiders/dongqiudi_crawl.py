# -*- coding: utf-8 -*-
import scrapy
from scrapy.spiders import CrawlSpider, Rule
from scrapy.linkextractors import LinkExtractor

# itemloader
from web_spider.items import RankItem

class DongqiudiCrawlSpider(CrawlSpider):
    name = 'dongqiudi_crawl'
    allowed_domains = ['dongqiudi.com']
    start_urls = ['https://www.dongqiudi.com/data']

    custom_settings = {
        # "FILES_STORE": SZ_FILE_PATH,
        # "FILES_URLS_FIELD": 'file_urls',
        "COOKIES_ENABLED": False,
        "DOWNLOAD_DELAY": 0,
        'DEFAULT_REQUEST_HEADERS': {
            'Accept': 'application/json, text/javascript, */*; q=0.01',
            'Accept-Encoding': 'gzip, deflate',
            'Content-Type': 'application/json;charset=UTF-8',
            'Accept-Language': 'zh-CN,zh;q=0.9,en;q=0.8,zh-TW;q=0.7,ja;q=0.6',
            'Connection': 'keep-alive',
            'Host': 'www.dongqiudi.com',
            'Origin': 'https://www.dongqiudi.com',
            'Referer': 'https://www.dongqiudi.com/',
            'User-Agent': 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/64.0.3282.140 Safari/537.36',
        }

    }

    rules = (
        Rule(LinkExtractor(allow=('www.dongqiudi.com/data/?competition=',)),callback='parse',follow=True),
        # Rule(LinkExtractor(allow=('www.lagou.com/jobs/',)), callback='parse_item', follow=True),
    )

    def parse(self,response):
        rank_list = response.css("#stat_detail table tr")
        rankItem = RankItem
        for item in rank_list:
            # for ditem in item.xpath('//td'):
                print(item.xpath('//th[0]'))
                pass