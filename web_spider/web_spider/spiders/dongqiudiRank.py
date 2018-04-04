import scrapy
from web_spider.items import RankItem
from scrapy.http import Request
from urllib import parse
import re

class RankSpider(scrapy.Spider):
    name="dongqiudiRank"
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
        # print(cur_links)
        next_url = response.css('#stat_tab a::attr(href)').extract()
        for link in cur_links:
            # url = parse.urljoin(response.url,link)
            # print(cur_links.index(link))
            yield Request(url=parse.urljoin(response.url, link), meta={'url': link,'index': cur_links.index(link)}, callback=self.parse_detail)
        # for next_link in next_url:
        #     yield Request(url=parse.urljoin(response.url, next_link), callback=self.parse)
        pass

    def parse_detail(self, response):
        # rank_list = response.css("#rank_list .stat_list")
        index = response.meta.get('index','') + 1
        rank_list = response.xpath("//table[@class='list_1']/tr")
        side_list = response.xpath("//div[@id='stat_list']/a[{0}]".format(index))
        # print(re.search('competition=(\d+)', response.url).group(1))
        rankItem = RankItem()
        for item in rank_list[2:]:

            rankItem['rank'] = item.xpath("./td[1]/text()").extract()[0]
            rankItem['team_avatar'] = item.xpath("./td[2]/a/img/@src").extract()[0]
            rankItem['team_name'] = item.xpath("./td[2]/a/text()").extract()[1].strip()
            rankItem['round'] = item.xpath("./td[3]/text()").extract()[0]
            rankItem['win'] = item.xpath("./td[4]/text()").extract()[0]
            rankItem['draw'] = item.xpath("./td[5]/text()").extract()[0]
            rankItem['lost'] = item.xpath("./td[6]/text()").extract()[0]
            rankItem['goal'] = item.xpath("./td[7]/text()").extract()[0]
            rankItem['fumble'] = item.xpath("./td[8]/text()").extract()[0]
            rankItem['GD'] = item.xpath("./td[9]/text()").extract()[0]
            rankItem['integral'] = item.xpath("./td[10]/text()").extract()[0]
            rankItem['rel'] = re.search('competition=(\d+)', response.url).group(1)
            rankItem['rel_name'] = side_list.xpath('./text()').extract()[0].strip()
            rankItem['type'] = 'rank'
            # print(rankItem)
            yield rankItem

        pass
