# -*- coding: utf-8 -*-

# Define your item pipelines here
#
# Don't forget to add your pipeline to the ITEM_PIPELINES setting
# See: https://doc.scrapy.org/en/latest/topics/item-pipeline.html


import pymysql






class WebSpiderPipeline(object):
    def process_item(self, item, spider):

        # print(item['name'])

        connection = pymysql.connect(host='127.0.0.1',
                                     user='root',
                                     password='123456',
                                     db='mydb',
                                     charset='utf8mb4',
                                     cursorclass=pymysql.cursors.DictCursor)

        try:
            with connection.cursor() as cursor:
                # Create a new record
                insert_sql = """INSERT INTO `dongqiudi` (`id`, `name`,`url`,`time`,`comment`,`image`)
                                                        VALUES (%s, %s,%s,%s,%s,%s)
                                                        ON DUPLICATE KEY UPDATE
                                                        id=VALUES(id),
                                                        name=VALUES(name),
                                                        url=VALUES (url),
                                                        time=VALUES (time),
                                                        comment=VALUES (comment),
                                                        image=VALUES (image)"""
                cursor.execute(insert_sql, (item['id'], item['name'], item['url'], item['time'], item['comment'],item['image']))

            # connection is not autocommit by default. So you must commit to save
            # your changes.
            connection.commit()

        finally:
            connection.close()

        pass
