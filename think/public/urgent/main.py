# -*- coding: utf-8 -*-
"""
Created on Wed Feb 23 18:34:55 2022

@author: 86184
"""
import sys
import warnings
import codecs
import jieba
import re
import numpy
import pandas as pd
from sklearn.feature_extraction.text import CountVectorizer
from sklearn.feature_extraction.text import TfidfTransformer
from sklearn.svm import LinearSVC

#################################关键词提取
# 创建语料库
warnings.filterwarnings('ignore')

fileContents = []
f = codecs.open("/var/www/html/disaster/think/public/urgent/test.txt", 'r', 'utf-8')
fileContent = f.read()
f.close()
fileContents.append(fileContent)

#读入数据
i=sys.argv[1]
fileContent = i
# 匹配中文分词
zhPattern = re.compile(u'[\u4e00-\u9fa5]+')

# 分词，转化为sklearn能识别的数据格式（分词之间以空格分开）
segments = []
segs = jieba.cut(fileContent)
for seg in segs:
    if zhPattern.search(seg):
        segments.append(seg)
filecontent= ' '.join(segments)  # 将文章分词以空格分开，以便符合sklearn数据格式要求

# 读取停用词文件
stopWords = pd.read_csv(
    '/var/www/html/disaster/think/public/urgent/StopwordsCN.txt',
    encoding='utf-8',
    index_col=False,
    quoting=3,
    sep='\t'
)

# 提取TF
countVectorizer = CountVectorizer(  # 该类会将文本中的词语转换为词频矩阵，矩阵元素a[i][j] 表示j词在i类文本下的词频
    stop_words=list(stopWords['stopword'].values),  # stopWords['stopword'].values为ndarray类型.stop_words接受list类型
    min_df=0,
    token_pattern=r"\b\w+\b"
)
textVector = countVectorizer.fit_transform([filecontent])  # 将文章转化为词频矩阵，得到TF矩阵
#print(textVector.todense())  # 使用todense 方法获得该矩阵

# 计算TF-IDF
transformer = TfidfTransformer()
tfidf = transformer.fit_transform(textVector)  # 为词频矩阵的每个词加上权重（即TF * IDF），得到TF-IDF矩阵
#print(tfidf.todense())

# 提取关键词
sort = numpy.argsort(tfidf.toarray(), axis=1)[:, -5:]  # 将二维数组中每一行按升序排序，并提取每一行的最后五个(即数值最大的的五个)
names = countVectorizer.get_feature_names()  # 获取词袋模型中的所有词语
#print("关键词如下：",names[-5:])

#####################紧急程度判断
#读入数据
urgent_train = pd.read_excel('/var/www/html/disaster/think/public/urgent/urgent_train.xlsx')
x_train_text = urgent_train['求助内容']
y_train = urgent_train['紧急程度']
x_test_text = i

#分词
train_num=x_train_text.shape[0]
for i in range(train_num):
    train_text=x_train_text.iloc[i]
    seg=jieba.cut(train_text)  
    train_new_text=' '.join(seg)
    x_train_text.iloc[i]=train_new_text
test_text=x_test_text
seg=jieba.cut(test_text)  
test_new_text=' '.join(seg)
x_test_text=[test_new_text]

#文本转为向量 
cv_urgent = CountVectorizer().fit(x_train_text)
x_train_text_cv = cv_urgent.transform(x_train_text)
x_test_text_cv = cv_urgent.transform(x_test_text)


#LinearSVC
svc_cv_steps = LinearSVC().fit(x_train_text_cv,y_train)
svc_cv_steps.fit(x_train_text_cv,y_train)
print(svc_cv_steps.predict(x_test_text_cv)[0])
