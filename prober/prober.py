#!/usr/bin/env python


import time 
from easysnmp import snmp_get, snmp_set, snmp_walk,snmp_get_bulk
import sys


N = int(sys.argv[3])
a = sys.argv[1]
agent_details = a.rsplit(':',1)
ip = agent_details[0]
commun= agent_details[1]
Fs = float(sys.argv[2])
Ts = float(1/Fs)

o1= ['1.3.6.1.2.1.1.3.0']
o2 = sys.argv[4:len(sys.argv)]
oids=o1+o2
l1 = []
v1 = []
l2 = []
v2 = []
T_start = time.clock()
n=1
try:
  sent_time1=time.time()
  req1 =  snmp_get(oids,hostname=ip,community=commun,version=2,timeout=5,retries=1)
  recv_time1 = time.time()
  for item in req1:
      a1 = item.value
      l1.append(a1)
      counter_type = item.snmp_type
  v1 = [s for s in l1[:] if s.isdigit()]
  if v1:
     val1 = map(int,v1[1:])
     
  if Fs>1:
     t1 = float(v1[0])/100 
  else:
     t1 = int(v1[0])/100 
  del l1[:] 
  recv2= time.time()   
  resp_time1=recv_time1 - sent_time1 
  cal1_time= recv2 - recv_time1
  if resp_time1>Ts:
    T_send=T_start + n*Ts 

  else:
    T_send= Ts-resp_time1-cal1_time
  time.sleep(T_send)

except:
  T_send = Ts
  time.sleep(T_send)
  pass

if N>0: 
 while N>=n:
  T_start1 = time.time()
  try:
    T_start1 = time.time()
    #print "T_start =",T_start
    req2 =  snmp_get(oids,hostname=ip,community=commun,version=2,timeout=5,retries=1)
    arrived_time=time.time()
    for item in req2:
      a2 = item.value
      l2.append(a2)
      counter_type = item.snmp_type
    v2 = [s for s in l2[:] if s.isdigit()]
    if v2:
      val2 = map(int,v2[1:])
     
    if Fs>1:
      t2 = float(v2[0])/100
    else:
      t2 = int(v2[0])/100
    #print "t2",t2
    resp2_time=arrived_time - T_start1
    #print "resp2_time=",resp2_time
    exec_start=time.time()          
    #print "val2",val2
    val2 = val2[:]
    c = []
    c = []
    for item in req2:
      counter_type = item.snmp_type
      c.append(counter_type)
    v = map(str,c[1:]) 
    d ={}
    d = dict(zip(v, val2))
    seen = set()
    s = len(val2)
    l = []
    bitcounter64 = 2**64
    if val1:
      for i in range(s):
        if val2[i] < val1[i]:
          if v[i] == "COUNTER64":
             while val2[i] < val1[i]:
                   val2[i] += bitcounter64
                   l.append(val2[i])
          seen.add(val2[i])
          if v[i] == "COUNTER":
                   val2[i] += 4294967296
                   l.append(val2[i])
          seen.add(val2[i])
      if t2>t1:
         try:
            t = t2-t1
            diff = [i1 - i2 for (i1, i2) in zip(val2, val1)]
            rate = [i / t  for i in diff]
            print int(arrived_time),"|", " | ".join(map(str,rate))
            
         except:
            pass
    
    else:
         print int(arrived_time),"|"
    val1 = val2
    t1 = t2
    del l2[:] 
    exec_end=time.time()
    exec_time= exec_end - arrived_time
    if resp2_time >Ts:
      T_send1 = T_start + n*Ts
    else:
      T_send1=Ts-resp2_time-exec_time
    time.sleep(T_send1)
  except:
    T_send1 = Ts
    time.sleep(T_send1)
    pass
  n= n+1
  #print "n=",n  
    #print "###############"       



    
  
