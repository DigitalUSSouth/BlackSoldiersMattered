var soldier1 = {
  "type": "Feature",
  "geometry": {
    "type": "MultiPoint",
    "coordinates": [
      [34.88593, -79.05762],
      [41.31082, -93.20801]
    ]
  },
  "properties": {
    "title" : "soldier1",
    "path_options" : { "color" : "red" },
    "time": [
      500000,
      510000
    ],
    "speed": [95,95],
    "altitude": [50,50],
    "heading": [0,0],
    "horizontal_accuracy": [0,0],
    "vertical_accuracy": [0,0],
    "raw": []
  },
  "bbox": [
    [
      47.57653, -119.39941
    ],
    [
     27.9944, -119.22363
    ],
    [
     5.58329, -74.04785
    ],
    [
      25.87899, -74.39941
    ]
  ]
};

var soldier2 = {
  "type": "Feature",
  "geometry": {
    "type": "MultiPoint",
    "coordinates": [
      [34.88593, -79.05762],
      [30.44867, -98.65723]
    ]
  },
  "properties": {
    "title" : "soldier2",
    "path_options" : { "color" : "blue" },
    "time": [
      500000,
      510000
    ]
  }
};


var soldier3 = {
  "type": "Feature",
  "geometry": {
    "type": "MultiPoint",
    "coordinates": [
      [35.38905, -76.86035],
      [38.82259, -105.86426]
    ]
  },
  "properties": {
    "title" : "soldier3",
    "path_options" : { "color" : "green" },
    "time": [
      500000,
      505000
    ]
  }
};

var soldiers = [soldier1 , soldier2, soldier3];
