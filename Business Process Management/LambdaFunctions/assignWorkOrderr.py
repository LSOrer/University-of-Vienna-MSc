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
    print("Attempted Login: " + json.dumps(event, indent=2))
    dynamodb = boto3.resource('dynamodb')
    orderTable = dynamodb.Table('Orders')
    orders = orderTable.scan().get('Items')
    workerid = str(event.get('WorkerID'))
    
    # get order
    order = orders[0]
    for current in orders:
        if current.get('Priority') < order.get('Priority') and current.get('WorkerID') == 'null':
            order = current
        elif current.get('Priority') == order.get('Priority') and current.get('WorkerID') == 'null':
            if calculateRelativeCompletion(current) > calculateRelativeCompletion(order):
                order = current
        
    #machine
    dynamodb = boto3.resource('dynamodb')
    machineTable = dynamodb.Table('Machines')
    machines = machineTable.scan().get('Items')
    selectedmachine = machines[0]
    
    for machine in machines:
        if machine.get('Type') == order.get('Type') and machine.get('WorkerID') == 'null':
            selectedmachine = machine
    
    #update in db
    orderupdate = orderTable.update_item(
        Key={
            'OrderID': order.get('OrderID')
        },
        UpdateExpression="set WorkerID=:r",
        ExpressionAttributeValues={
            ':r': workerid
        },
        ReturnValues="UPDATED_NEW"
    )
    print(orderupdate)
    
    machineupdate = machineTable.update_item(
        Key={
            'MachineID': selectedmachine.get('MachineID')
        },
        UpdateExpression="set WorkerID=:r",
        ExpressionAttributeValues={
            ':r': workerid
        },
        ReturnValues="UPDATED_NEW"
    )
    print("updating machine")
    print(machineupdate)

    return {
        "WorkerID": workerid,
        "OrderID": order.get('OrderID'),
        "CurrentAmount": order.get('CurrentAmount'),
        "TotalAmount": order.get('TotalAmount'),
        "HourlyRate": order.get('HourlyRate'),
        "Location": machine.get('Location'),
        "MachineID": machine.get('MachineID')
    };