import cv2
import pygame
import time

# Initialiser pygame pour la lecture audio
pygame.mixer.init()
try:
    pygame.mixer.music.load("public/mp3/detectionVisage.mp3")
    print("Fichier audio chargé avec succès.")
except pygame.error as e:
    print(f"Erreur lors du chargement du fichier audio: {e}")
    exit()

# Capture vidéo à partir de la caméra par défaut
cap = cv2.VideoCapture(0, cv2.CAP_DSHOW)

if not cap.isOpened():
    print("Erreur: Impossible d'ouvrir la caméra.")
    exit()

# Chargement du classificateur de cascade pour la détection de visages
face_cascade_path = cv2.data.haarcascades + 'haarcascade_frontalface_default.xml'
face_cascade = cv2.CascadeClassifier(face_cascade_path)

if face_cascade.empty():
    print(f"Erreur: Impossible de charger le classificateur de cascade à partir de {face_cascade_path}.")
    exit()

# Définir le temps de début
start_time = time.time()

while True:
    # Capture d'une frame
    ret, frame = cap.read()

    if not ret:
        print("Erreur: Impossible de lire la frame de la caméra.")
        break

    # Convertir l'image en niveaux de gris
    gray = cv2.cvtColor(frame, cv2.COLOR_BGR2GRAY)

    # Détection des visages dans l'image
    faces = face_cascade.detectMultiScale(gray, scaleFactor=1.1, minNeighbors=5, minSize=(30, 30))

    # Si un visage est détecté, jouer le message audio
    if len(faces) > 0:
        if not pygame.mixer.music.get_busy():
            pygame.mixer.music.play()
            print("Message audio en cours de lecture.")

    # Dessiner un rectangle autour des visages détectés
    for (x, y, w, h) in faces:
        cv2.rectangle(frame, (x, y), (x+w, y+h), (255, 0, 0), 2)

    # Affichage du résultat
    cv2.imshow('Face Detection', frame)

    # Attendre 1 ms pour quitter si 'q' est pressé ou si 10 secondes se sont écoulées
    if cv2.waitKey(1) & 0xFF == ord('q') or (time.time() - start_time) > 10:
        break

# Libérer la capture et détruire toutes les fenêtres OpenCV
cap.release()
cv2.destroyAllWindows()
pygame.mixer.quit()
