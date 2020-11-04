## User listing

### Endpoint: http://ec2-52-42-253-146.us-west-2.compute.amazonaws.com/api/leaderboard (GET)

This API is to return a list of users order by their score in a descending order. 



## Get specific user

### Endpoint: http://ec2-52-42-253-146.us-west-2.compute.amazonaws.com/api/get-user/{id} (GET)

This API is to return a single user base on the user id provided.

examples:
- http://ec2-52-42-253-146.us-west-2.compute.amazonaws.com/api/get-user/1




## Create user

### Endpoint: http://ec2-52-42-253-146.us-west-2.compute.amazonaws.com/api/create (POST)

This API is to create an user with the following parameters:
- name
- age
- address

In postman, please use form-data to provide key value pair.
points will be default to 0 upon user creation.



## Update points

### Endpoint: http://ec2-52-42-253-146.us-west-2.compute.amazonaws.com/api/update-points/{id}/{modifier} (GET)

This API is to update scores according provided user id and modifier.

exemples:
 - http://ec2-52-42-253-146.us-west-2.compute.amazonaws.com/api/update-points/1/+  will add 1 point to user id 1
 - http://ec2-52-42-253-146.us-west-2.compute.amazonaws.com/api/update-points/1/-  will minus 1 point from user id 1

Each action (+ or -) will only add or deduct 1 point from an user.



## Delete User

### Endpoint: http://ec2-52-42-253-146.us-west-2.compute.amazonaws.com/api/delete-user/{id} (DELETE)

This API is to delete an user base on the user id provided.

examples:
- http://ec2-52-42-253-146.us-west-2.compute.amazonaws.com/api/delete-user/1
