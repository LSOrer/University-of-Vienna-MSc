from __future__ import print_function

import json
import boto3
from boto3.dynamodb.conditions import Key, Attr
from pprint import pprint
from botocore.exceptions import ClientError

batch = boto3.client('batch')

def calculateRelativeCompletion(order):
    return order.get('CurrentAmount')/order.get('TotalAmount')

def lambda_handler(event, context):
    print("Requested Report")
    dynamodb = boto3.resource('dynamodb')
    
    reportTable = dynamodb.Table('DailyReport')
    reports = reportTable.scan().get('Items')
    
    response = 0
    
    for report in reportTable.scan().get('Items'):
        response = reportTable.get_item(Key={'ReportID': "1"})
            
    return response.get('Item');