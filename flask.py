# C:\Users\Ethan\AppData\Local\Programs\Python\Python37\python.exe python

from flask import Flask, jsonify
from flask_cors import CORS
import json
import pose_similarity

app = Flask(__name__)
CORS(app)

# min function for array size
def min(arr1, arr2):
    if len(arr1) > len(arr2):
        return len(arr2)

    return len(arr1)


# loading json into array
part_names = ["head", "neck", "rshoulder", "relbow", "rhand", "lshoulder", "leblow", "lhand",
                  "rhip", "rknee", "rfoot", "lhip", "lknee", "lfoot", "reye", "leye", "rear", "lear"]

@app.route('/totalerror', methods=['GET', 'POST'])
def totalerror():
    with open("pose-json/base-poses.json", 'r') as file:
        info = json.loads(file.readline())
        video1json = info['frames']

    # load json to compare info
    with open("pose-json/compare-poses.json", 'r') as file:
        info = json.loads(file.readline())
        video2json = info['frames']

    video1 = [[0 for x in range(36)] for y in range(min(video1json, video2json))]
    video2 = [[0 for x in range(36)] for y in range(min(video1json, video2json))]

    framesoff = 0

    for i in range(0, min(video1json, video2json)):
        counter = 0
        for j in range(0, 18):
            video1[i][counter] = video1json[i][part_names[j] + 'x']
            video2[i][counter] = video2json[i][part_names[j] + 'x']
            counter += 1
            video1[i][counter] = video1json[i][part_names[j] + 'y']
            video2[i][counter] = video2json[i][part_names[j] + 'y']
            counter += 1

        if pose_similarity.averageError(i, video1, video2) > 0.2:
            framesoff += 1

    return str(framesoff/min(video1json, video2json))


@app.route('/framenumbers', methods=['GET', 'POST'])
def framenumbers():
    with open("pose-json/base-poses.json", 'r') as file:
        info = json.loads(file.readline())
        video1json = info['frames']

    # load json to compare info
    with open("pose-json/compare-poses.json", 'r') as file:
        info = json.loads(file.readline())
        video2json = info['frames']

    video1 = [[0 for x in range(36)] for y in range(min(video1json, video2json))]
    video2 = [[0 for x in range(36)] for y in range(min(video1json, video2json))]

    frameswrong = []
    frameerror = []

    for i in range(0, min(video1json, video2json)):
        counter = 0
        for j in range(0, 18):
            video1[i][counter] = video1json[i][part_names[j] + 'x']
            video2[i][counter] = video2json[i][part_names[j] + 'x']
            counter += 1
            video1[i][counter] = video1json[i][part_names[j] + 'y']
            video2[i][counter] = video2json[i][part_names[j] + 'y']
            counter += 1

        if pose_similarity.averageError(i, video1, video2) > 0.2:
            frameswrong.append(i)
            frameerror.append(pose_similarity.averageError(i, video1, video2))

    jsonstring = '{"frames":['

    for i in range(0, len(frameswrong)):
        jsonstring += '{"name":"frame' + str(frameswrong[i] + 1).zfill(6) + '.jpg"'
        jsonstring += ',"error":' + str(frameerror[i])
        jsonstring += ',"timestamp":' + str(frameswrong[i] * 0.15)
        jsonstring += "},"

    jsonstring = jsonstring[:-1]
    jsonstring += "]}"
    return json.loads(jsonstring)


@app.route('/continuouserror', methods=['GET', 'POST'])
def continuouserror():
    with open("pose-json/base-poses.json", 'r') as file:
        info = json.loads(file.readline())
        video1json = info['frames']

    # load json to compare info
    with open("pose-json/compare-poses.json", 'r') as file:
        info = json.loads(file.readline())
        video2json = info['frames']

    video1 = [[0 for x in range(36)] for y in range(min(video1json, video2json))]
    video2 = [[0 for x in range(36)] for y in range(min(video1json, video2json))]

    getEvery = round(min(video1json, video2json) / 6)

    framesoff = 0
    cum_accuracy = 100
    cum_accuracy_coords = []

    for i in range(0, min(video1json, video2json)):
        counter = 0
        for j in range(0, 18):
            video1[i][counter] = video1json[i][part_names[j] + 'x']
            video2[i][counter] = video2json[i][part_names[j] + 'x']
            counter += 1
            video1[i][counter] = video1json[i][part_names[j] + 'y']
            video2[i][counter] = video2json[i][part_names[j] + 'y']
            counter += 1

        if pose_similarity.averageError(i, video1, video2) > 0.20:
            framesoff += 1

        if i % getEvery == 0 and i != 0:
            cum_accuracy = 100 - (framesoff / min(video1json, video2json)) * 100
            print(cum_accuracy)
            cum_accuracy_coords.append(cum_accuracy)

        elif i == 0:
            print(cum_accuracy)
            cum_accuracy_coords.append(cum_accuracy)

    jsonstring = '{"coords":['
    for i in range (0, len(cum_accuracy_coords)):
        jsonstring += str(cum_accuracy_coords[i]) + ','
    jsonstring = jsonstring[:-1]
    jsonstring += "]}"

    return json.loads(jsonstring)


if __name__ == '__main__':
    app.run(host="0.0.0.0",port=5000,debug=True)