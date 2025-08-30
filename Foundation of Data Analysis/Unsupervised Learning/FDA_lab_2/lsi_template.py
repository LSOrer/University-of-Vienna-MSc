#!/usr/bin/env python3

import pprint # pretty printer
import logging
from sklearn.datasets import fetch_20newsgroups
from fda_helper import preprocess_data
from gensim import corpora, models, similarities

# enable logging to display what is happening
logging.basicConfig(format='%(asctime)s : %(levelname)s : %(message)s', level=logging.INFO)

# read dataset 20newsgroups
dataset = fetch_20newsgroups(shuffle=True, random_state=1, remove=('headers', 'footers', 'quotes'))
documents = dataset.data

texts = preprocess_data(documents)
dictionary = corpora.Dictionary(texts)

bow_corpus = [dictionary.doc2bow(text) for text in texts] # bow = Bag Of Words
#pprint.pprint(bow_corpus[5]) # one example document, words maped to ids

tfidf = models.TfidfModel(bow_corpus) # train tf-idf model
corpus_tfidf = tfidf[bow_corpus] # apply transformation on the whole corpus

##  TODO: transform your tfidf model into a LSI Model
##  using python gensim, use num_topics=200
# from https://markroxor.github.io/gensim/static/notebooks/Topics_and_Transformations.html - line #28 - #29
lsi = models.LsiModel(corpus_tfidf, id2word=dictionary, num_topics=200)
corpus_lsi = lsi[corpus_tfidf]

## TODO: query! pick a random document and formulate a query based on the
## terms in the document.
# https://radimrehurek.com/gensim/auto_examples/core/run_similarity_queries.html#sphx-glr-auto-examples-core-run-similarity-queries-py - line #46 - #51

#query based upon manually choosen key-words of an article
#doc = "peir yuan yeh" 
doc = "Old Testament Moslem God manuscript Isaiah"
words_bow = dictionary.doc2bow(doc.lower().split())

#query based upon non-preprocessed document 
doc_bow = dictionary.doc2bow(documents[643].lower().split())

#query based upon preprocessed document - see line #16
texts_bow = dictionary.doc2bow(texts[643])

#convert the query to LSI space
#decide if you want to base the query upon manually picked words (=words_bow), upon a non-preprocessed document (=doc_bow) or upon a preprocessed document (=texts_bow)
vec_lsi = lsi[texts_bow]  

## TODO: initialize a query structure for your LSI space
index = similarities.MatrixSimilarity(corpus_lsi)  # transform corpus to LSI space and index it

## TODO: perform the query on the LSI space, interpret the result and summarize your findings in the report
sims = index[vec_lsi]  # perform a similarity query against the corpus
sims = sorted(enumerate(sims), key=lambda item: -item[1])

#print the 10 best matching documents
#you can increase the secound parameter of the range if you'd like to see more results
for i in range(0, 10):
    print(i, sims[i])