# task 2

# requests to the server, building a load balancer in php

server has a cluster with 4 nodes. Each of these has different Memory sizes(RAM), Number of CPUs. Represent each node as a website, hosted using Apache on 4 different ports.

database with 2 tables
Table 1:
name: nodes
columns: Name, Number of CPUs, Available CPUs, Memory Size, Available Memory
(This table contains the status of each node. Add 4 entries in this table manually.)

Table 2:
name : Requests
Columns: Id, allocated_node_name, Starttime, CPU required, Memory required, time_required_for_completion

Each of these websites(nodes) will display the processes which are currently running on the respective node.

a website for the actual load balancer logic, the load balancer should handle the requests, and assign them to most suitable node. A record should be created in the request table with allocated node and other parameters. Record for the corresponding node should change accordingly. (i.e. available memory, available cpu should be updated).
The processes will run for “time required” units of time.
The websites(nodes) should also display completed requests below under a heading named History.

Finally, to test the load balancer,  a python script to randomly generate post requests with the paramaters : CPU needed, Memory needed, Time to process. This request is sent to the load balancer website from the script itself.
If none of the nodes can handle the request, then reject the request with message can’t handle.
