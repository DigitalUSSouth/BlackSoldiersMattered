import json
data={}
with open('units.json', 'w') as outfile,open("units.txt","r") as f:
    ite = 0
    lines = file.read(f).split("\n")
    for line in lines:
       ite+= 1
       sp=line.split('\t')[0]
       data.setdefault("data",[]).append({"text": sp[1],"id": sp[0]})
    json.dump(data, outfile)
