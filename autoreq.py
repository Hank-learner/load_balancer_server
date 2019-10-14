import requests
import random

idval = random.randint(1,1000)
cpu = random.randint(1,30)
memory = random.randint(1,220)
reqtime = random.randint(0,1000)

 
tabledetails = {'ID':idval,'CPU_required':cpu,'Memory_required':memory ,'time_required_for_completion':reqtime}

request = requests.post("http://localhost:81/loadbalancer.php",tabledetails)