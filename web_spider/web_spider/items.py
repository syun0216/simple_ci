# -*- coding: utf-8 -*-

# Define here the models for your scraped items
#
# See documentation in:
# https://doc.scrapy.org/en/latest/topics/items.html

import scrapy


class WebSpiderItem(scrapy.Item):
    # define the fields for your item here like:
    # name = scrapy.Field()
    pass


class ToutiaoItem(scrapy.Item):
    url = scrapy.Field()
    name = scrapy.Field()
    time = scrapy.Field()
    comment = scrapy.Field()
    id = scrapy.Field()
    image = scrapy.Field()
    pass

class RankItem(scrapy.Item):
    id = scrapy.Field()
    rank = scrapy.Field()
    team_avatar = scrapy.Field()
    team_name = scrapy.Field()
    win = scrapy.Field()
    draw = scrapy.Field()
    lost = scrapy.Field()
    integral = scrapy.Field()
    pass