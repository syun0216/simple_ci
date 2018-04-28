import os
import sys

sys.path.append(os.path.dirname(os.path.abspath(__file__)))

# os.system("scrapy crawl dongqiudi")
#
# os.system("scrapy crawl dongqiudiRank")

os.system("scrapy crawl dongqiudiPlayerRank")

# os.system("scrapy crawl dongqiudi_crawl")