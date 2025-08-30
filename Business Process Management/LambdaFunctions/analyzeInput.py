from __future__ import print_function

import json
import boto3
from boto3.dynamodb.conditions import Key, Attr
from pprint import pprint

def compare_keys(a, b):
    for key in a.keys():
        if b.get(key) is None:
           return 0;
    if not a.keys():
        return 0;
    return 1;

def lambda_handler(event, context):
    
    login_signature = {
        "WorkerID" : ""
    }   
    
    logout_signature = {
        "CompletedAmount" : "",
        "WorkerID" : "",
        "Begin" : "",
        "End" : ""
    }
    
    report_signature = {
    }

    if bool(compare_keys(event, login_signature)):
        return {
            "Requesttype" : "LOGIN",
            "WorkerID" : event.get('WorkerID')
        }   
    elif bool(compare_keys(event, logout_signature)):
        return {
            "Requesttype" : "LOGOUT",
            "WorkerID" : event.get('WorkerID'),
            "Begin" : event.get('Begin'),
            "End" : event.get('End'),
            "CompletedAmount" : event.get('CompletedAmount'),
        }
    else:
        return {
            "Requesttype" : "REPORT"
        };
