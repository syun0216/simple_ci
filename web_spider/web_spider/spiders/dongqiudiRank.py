import scrapy
from web_spider.items import RankItem

class RankSpider(scrapy.Spider):
    name="dongqiudiRank"
    allow_domain = ["dongqiudi.com"]
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

    def parse(self, response):
        rank_list = response.css("#rank_list .stat_list")
        rankItem = RankItem()
        for item in rank_list:
            rankItem['id'] = item.css('td span::text').extract()[0]
            rankItem['rank'] = item.css('td span::text').extract()[0]
            rankItem['team_name'] = item.css('.team_name a::text').extract()[0]
            rankItem['team_avatar'] = item.css('.team_name a img::attr(src)').extract()[0]
            # rankItem['integral'] = item.css('')
            print(rankItem)
            pass
