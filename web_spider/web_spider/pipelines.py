# -*- coding: utf-8 -*-

# Define your item pipelines here
#
# Don't forget to add your pipeline to the ITEM_PIPELINES setting
# See: https://doc.scrapy.org/en/latest/topics/item-pipeline.html


import pymysql






class WebSpiderPipeline(object):
    def init_insert_db(self,key,table_name):

        pass
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

                if item['type'] == 'toutiao':
                    insert_sql = """INSERT INTO `dongqiudi` (`id`, `name`,`url`,`time`,`comment`,`image`)
                                                            VALUES (%s, %s,%s,%s,%s,%s)
                                                            ON DUPLICATE KEY UPDATE
                                                            id=VALUES(id),
                                                            name=VALUES(name),
                                                            url=VALUES (url),
                                                            time=VALUES (time),
                                                            comment=VALUES (comment),
                                                            image=VALUES (image)"""
                    cursor.execute(insert_sql, (item['id'], item['name'], item['url'], item['time'], item['comment'], item['image']))

                elif item['type'] == 'rank':
                    insert_sql = """INSERT INTO `rank` (`rank`,`team_avatar`,`team_name`,`round`,`win`,`draw`,`lost`,`goal`,`fumble`,`GD`,`integral`,`rel`,`rel_name`)
                                    VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)
                                    ON DUPLICATE KEY UPDATE
                                    rank=VALUES (rank),
                                    team_avatar=VALUES (team_avatar),
                                    team_name=VALUES (team_name),
                                    round=VALUES (round),
                                    win=VALUES (win),
                                    draw=VALUES (draw),
                                    lost=VALUES (lost),
                                    goal=VALUES (goal),
                                    fumble=VALUES (fumble),
                                    GD=VALUES (GD),
                                    integral=VALUES (integral),
                                    rel=VALUES (rel),
                                    rel_name=VALUES (rel_name)

                    """
                    cursor.execute(insert_sql,
                               (item['rank'], item['team_avatar'], item['team_name'], item['round'], item['win'], item['draw'],item['lost'],item['goal'],item['fumble'],item['GD'],item['integral'],item['rel'],item['rel_name']))

            # connection is not autocommit by default. So you must commit to save
            # your changes.
            connection.commit()

        finally:
            connection.close()

        pass
