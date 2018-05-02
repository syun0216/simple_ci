import scrapy
from web_spider.items import PlayRankItem
from scrapy.http import Request
from urllib import parse
import re


class PlayerRankSpider(scrapy.Spider):
    name = 'dongqiudiPlayerRank'
    allow_domain = ["dongqiudi.com"]
    start_urls = ["https://www.dongqiudi.com/data"]

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

    def parse(self,response):
        cur_links = response.css('#stat_list a::attr(href)').extract()
        goal_url = '&type=goal_rank'
        assist_url = '&type=assist_rank'
        for link in cur_links:
            # print(parse.urljoin(response.url,link+goal_url))
            yield Request(url=parse.urljoin(response.url, link+goal_url),meta={'url': link,'index': cur_links.index(link),'type': 'goal'},callback=self.parse_player_goal_details)
            yield Request(url=parse.urljoin(response.url, link+assist_url),meta={'url': link,'index': cur_links.index(link),'type': 'assist'},callback=self.parse_player_goal_details)
        pass

    def parse_player_goal_details(self, response):
        index = response.meta.get('index', '') + 1
        rank_list = response.xpath("//table[@class='list_1']/tr")
        side_list = response.xpath("//div[@id='stat_list']/a[{0}]".format(index))
        playerItem = PlayRankItem()

        for item in rank_list[1:]:
            playerItem['rank'] = item.xpath("./td[1]/text()").extract()[0]
            playerItem['player_avatar'] = item.xpath("./td[2]/a/img/@src").extract()[0]
            playerItem['player_name'] = item.xpath("./td[2]/a/text()").extract()[1].strip()
            playerItem['team_avatar'] = item.xpath("./td[3]/a/img/@src").extract()[0]
            playerItem['team_name'] = item.xpath("./td[3]/a/text()").extract()[1].strip()
            playerItem['data'] = item.xpath("./td[4]/text()").extract()[0]
            playerItem['rel'] = re.search('competition=(\d+)', response.url).group(1)
            playerItem['rel_name'] = side_list.xpath('./text()').extract()[0].strip()
            playerItem['type'] = response.meta.get('type', '')
            yield playerItem

        pass


