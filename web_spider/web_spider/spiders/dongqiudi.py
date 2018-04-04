import scrapy
# import web_spider.items
from web_spider.items import ToutiaoItem
import re
from scrapy.http import Request

class DongqiudiSpider(scrapy.Spider):
    name="dongqiudi"
    allow_domain= ["dongqiudi.com"]
    start_urls = ["https://www.dongqiudi.com/#"]

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
            'Host': 'query.sse.com.cn',
            'User-Agent': 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/64.0.3282.140 Safari/537.36',
        }

    }

    #
    # def parseItem(self, response):
    #     url_list = response.css("#news_list ol li").extract()
    #     for item in url_list:
    #         name = item.css("h2 a::text()").extract()[0]
    #         yield Request(name, )


    def parse(self, response):
        # filename = response.url.split("/")[-2]
        # with open(filename, 'wb') as f:
        #     f.write(response.body)

        url_list = response.css("#news_list ol li")
        for item in url_list:

            # print(item.css('h2 a::attr(href)').extract()[0])
            toutiaoItem = ToutiaoItem()
            url = item.css('h2 a::attr(href)').extract()[0]
            toutiaoItem['id'] = re.search('archive/(\d+)', url).group(1)
            toutiaoItem["name"] = item.css('h2 a::text').extract()[0]
            toutiaoItem['url'] = url
            toutiaoItem['time'] = item.css('.info .time::text').extract()[0]
            toutiaoItem['comment'] = item.css('.info a::attr(href)').extract()[0]
            toutiaoItem['image'] = item.css('a img::attr(src)').extract()[0]
            toutiaoItem['type'] = "toutiao"
            yield toutiaoItem

        pass

        # item = ToutiaoItem()
        # item["url"] = response.