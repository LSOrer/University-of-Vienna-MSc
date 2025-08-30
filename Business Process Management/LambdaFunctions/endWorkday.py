from __future__ import print_function

import json
import boto3
from boto3.dynamodb.conditions import Key, Attr
from pprint import pprint
from botocore.exceptions import ClientError
from datetime import datetime

batch = boto3.client('batch')

base_pay = 18.68
flat_subsidies = 23.50

def lambda_handler(event, context):
   
    print("Worker signing off: " + json.dumps(event, indent=2))
    dynamodb = boto3.resource('dynamodb')
    orderTable = dynamodb.Table('Orders')
    orders = orderTable.scan().get('Items')

    reportTable = dynamodb.Table('DailyReport')
    
    fmt = '%H:%M'
    begintime = datetime.strptime(event.get('Begin'), fmt)
    endtime = datetime.strptime(event.get('End'), fmt)
    totaltime = (endtime - begintime).total_seconds() / 3600.0
    workedon_order = orders[0]
    
    # reset
    for order in orders:
        if order.get('WorkerID') == event.get('WorkerID'):
            workedon_order = order
            #reset to null
            orderTable.update_item(
                Key={
                    'OrderID': order.get('OrderID')
                },
                UpdateExpression="set WorkerID=:r, CurrentAmount=:a",
                ExpressionAttributeValues={
                    ':r': 'null',
                    ':a': order.get('CurrentAmount') + int(event.get('CompletedAmount'))
                },
                ReturnValues="UPDATED_NEW"
            )
            
            
    # machine
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

    return {
        'OrderID': workedon_order.get('OrderID'),
        'Worktime': str(totaltime),
        'Payment': str(totaltime*base_pay+flat_subsidies)
    }
        