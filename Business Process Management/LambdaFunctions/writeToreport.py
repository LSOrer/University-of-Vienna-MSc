from __future__ import print_function

import json
import boto3
from boto3.dynamodb.conditions import Key, Attr
from pprint import pprint
from botocore.exceptions import ClientError
from datetime import datetime
from decimal import Decimal

batch = boto3.client('batch')

def lambda_handler(event, context):
    dynamodb = boto3.resource('dynamodb')

    reportTable = dynamodb.Table('DailyReport')
    reports = reportTable.scan().get('Items')
    
    response = 0
    
    x = json.loads(json.dumps(event), parse_float=Decimal)
    payload = x.get('Payload')
    
    if len(reports) == 0:
        response = reportTable.put_item(
           Item={
                'ReportID': "1",
                'Orders': payload.get('OrderID'),
                'Worktime': payload.get('Worktime'),
                'Payment': payload.get('Payment')
            }
        )
    else:
        for report in reportTable.scan().get('Items'):
            response = reportTable.update_item(
                Key={
                    'ReportID': report.get('ReportID')
                },
                UpdateExpression="set Orders=:o, Worktime=:w, Payment=:p",
                ExpressionAttributeValues={
                    ':o': report.get('Orders') + ', ' + payload.get('OrderID'),
                    ':w':""+ str(float(report.get('Worktime')) + float(payload.get('Worktime'))),
                    ':p':""+ str(float(report.get('Payment')) + float(payload.get('Payment')))
                },
                ReturnValues="UPDATED_NEW"
            )
            
    return payload;
        