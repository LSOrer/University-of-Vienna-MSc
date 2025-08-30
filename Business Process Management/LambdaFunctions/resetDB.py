from __future__ import print_function

import json
import boto3
from boto3.dynamodb.conditions import Key, Attr
from pprint import pprint
from botocore.exceptions import ClientError

batch = boto3.client('batch')

def lambda_handler(event, context):
    dynamodb = boto3.resource('dynamodb')
    orderTable = dynamodb.Table('Orders')
    orders = orderTable.scan().get('Items')
    
    # get order
    for current in orders:
        orderTable.update_item(
            Key={
                'OrderID': current.get('OrderID')
            },
            UpdateExpression="set WorkerID=:r",
            ExpressionAttributeValues={
                ':r': 'null'
            },
            ReturnValues="UPDATED_NEW"
        )
            
    #machine
    dynamodb = boto3.resource('dynamodb')
    machineTable = dynamodb.Table('Machines')
    machines = machineTable.scan().get('Items')
    
    for machine in machines:
      machineTable.update_item(
            Key={
                'MachineID': machine.get('MachineID')
            },
            UpdateExpression="set WorkerID=:r",
            ExpressionAttributeValues={
                ':r': 'null'
            },
            ReturnValues="UPDATED_NEW"
        )
        
    reportTable = dynamodb.Table('DailyReport')
    reports = reportTable.scan().get('Items')
    
    for report in reportTable.scan().get('Items'):
        response = reportTable.update_item(
            Key={
                'ReportID': report.get('ReportID')
            },
            UpdateExpression="set Orders=:o, Worktime=:w, Payment=:p",
            ExpressionAttributeValues={
                ':o': "",
                ':w': 0,
                ':p': 0
            },
            ReturnValues="UPDATED_NEW"
        )
            
    return 0
        
