import os
import cv2

# Obtenez le répertoire de base de cv2 (OpenCV)
cv2_base_dir = os.path.dirname(os.path.abspath(cv2.__file__))

# Chemin complet vers le fichier haarcascade_frontalface_default.xml
haar_model = os.path.join(cv2_base_dir, 'data', 'haarcascade_frontalface_default.xml')

print("Chemin du fichier XML : ", haar_model)
