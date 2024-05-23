import cv2
import time

# Capture vidéo à partir de la caméra par défaut
cap = cv2.VideoCapture(0, cv2.CAP_DSHOW)

if not cap.isOpened():
    print("Erreur: Impossible d'ouvrir la caméra.")
    exit()

print("Caméra ouverte avec succès.")

# Définir le temps de début
start_time = time.time()

while True:
    # Capture d'une frame
    ret, frame = cap.read()

    if not ret:
        print("Erreur: Impossible de lire la frame de la caméra.")
        break

    # Convertir la frame en niveau de gris pour améliorer la détection des visages
    gray = cv2.cvtColor(frame, cv2.COLOR_BGR2GRAY)

    # Vérifier que la frame est correctement convertie en niveau de gris
    print("Frame shape:", gray.shape)

    # Définir le détecteur de visages
    face_cascade = cv2.CascadeClassifier(cv2.data.haarcascades + 'haarcascade_frontalface_default.xml')

    # Détection des visages
    faces = face_cascade.detectMultiScale(gray, scaleFactor=1.1, minNeighbors=5, minSize=(30, 30))

    # Vérifier que des visages ont été détectés
    if len(faces) == 0:
        print("Aucun visage détecté.")

    # Dessiner un rectangle autour de chaque visage détecté
    for (x, y, w, h) in faces:
        cv2.rectangle(frame, (x, y), (x+w, y+h), (0, 255, 0), 2)

    # Afficher la frame avec les visages détectés
    cv2.imshow('Raw Camera Feed', frame)

    # Attendre 1 ms pour quitter si 'q' est pressé ou si 10 secondes se sont écoulées
    if cv2.waitKey(1) & 0xFF == ord('q') or (time.time() - start_time) > 10:
        break

# Libérer la capture et détruire toutes les fenêtres OpenCV
cap.release()
cv2.destroyAllWindows()


# # proposition groq, tentaive de connexion démarrage de ce fichier en même temps que l'activation de la camera
# import cv2
# import time

# # Capture vidéo à partir de la caméra par défaut
# cap = cv2.VideoCapture(0, cv2.CAP_DSHOW)

# if not cap.isOpened():
#     print("Erreur: Impossible d'ouvrir la caméra.")
#     exit()

# print("Caméra ouverte avec succès.")

# # Définir le temps de début
# start_time = time.time()

# while True:
#     # Capture d'une frame
#     ret, frame = cap.read()

#     if not ret:
#         print("Erreur: Impossible de lire la frame de la caméra.")
#         break

#     # Convertir la frame en niveau de gris pour améliorer la détection des visages
#     gray = cv2.cvtColor(frame, cv2.COLOR_BGR2GRAY)

#     # Vérifier que la frame est correctement convertie en niveau de gris
#     print("Frame shape:", gray.shape)

#     # Définir le détecteur de visages
#     face_cascade = cv2.CascadeClassifier(cv2.data.haarcascades + 'haarcascade_frontalface_default.xml')

#     # Détection des visages
#     faces = face_cascade.detectMultiScale(gray, scaleFactor=1.1, minNeighbors=5, minSize=(30, 30))

#     # Vérifier que des visages ont été détectés
#     if len(faces) == 0:
#         print("Aucun visage détecté.")

#     # Dessiner un rectangle autour de chaque visage détecté
#     for (x, y, w, h) in faces:
#         cv2.rectangle(frame, (x, y), (x+w, y+h), (0, 255, 0), 2)

#     # Afficher la frame avec les visages détectés
#     cv2.imshow('Raw Camera Feed', frame)

#     # Attendre 1 ms pour quitter si 'q' est pressé ou si 10 secondes se sont écoulées
#     if cv2.waitKey(1) & 0xFF == ord('q') or (time.time() - start_time) > 10:
#         break

# # Libérer la capture et détruire toutes les fenêtres OpenCV
# cap.release()
# cv2.destroyAllWindows()