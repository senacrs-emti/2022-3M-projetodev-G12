from tkinter import E
import cv2
import time
import requests
import json

cap = cv2.VideoCapture(0)
cap.set(cv2.CAP_PROP_FRAME_WIDTH, 1280)
cap.set(cv2.CAP_PROP_FRAME_HEIGHT, 720)

while True:
    _, frame = cap.read()
    hsv_frame = cv2.cvtColor(frame, cv2.COLOR_BGR2HSV)
    height, width, _ = frame.shape

    cx = int(width / 2)
    cy = int(height / 2)

    pixel_center = hsv_frame[cy, cx]
    hue_value = pixel_center[0]

    color = "Undefined"

    if (hue_value >= 40 and hue_value <= 90):
        color = "#008000"

    elif (hue_value >= 90 and hue_value <= 190):
        color = "#000000"

    elif (hue_value >= 3 and hue_value <= 35):
        color = "#FF0000"

    else:
        color = str(hue_value)
    

    pixel_center_bgr = frame[cy, cx]
    b, g, r = int(pixel_center_bgr[0]), int(pixel_center_bgr[1]), int(pixel_center_bgr[2])

    cv2.rectangle(frame, (cx - 220, 10), (cx + 200, 120), (255, 255, 255), -1)
    cv2.putText(frame, color, (cx - 200, 100), 0, 3, (b, g, r), 5)
    cv2.circle(frame, (cx, cy), 5, (25, 25, 25), 3)

    print(color)

    cv2.imshow("Frame", frame)

    cor = {"cor": color}

    r = requests.post("https://hiperwaves.com/endpoint/api.php", data=cor)

    key = cv2.waitKey(1)
    if key == 27:
        break

cap.release()
cv2.destroyAllWindows()