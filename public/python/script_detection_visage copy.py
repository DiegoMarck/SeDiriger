# import cv2
# import pygame

# # Initialiser pygame pour la lecture audio
# pygame.mixer.init()
# pygame.mixer.music.load("public/mp3/detectionVisage.mp3")  # Remplacez "path/to/your/audio/message.mp3" par le chemin de votre fichier audio

# # Capture vidéo à partir de la caméra par défaut
# cap = cv2.VideoCapture(0)

# if not cap.isOpened():
#     print("Erreur: Impossible d'ouvrir la caméra.")
#     exit()
    
# # Chargement du classificateur de cascade pour la détection de visages
# face_cascade = cv2.CascadeClassifier(cv2.data.haarcascades + 'haarcascade_frontalface_default.xml')

# while True:
#     # Capture d'une frame
#     ret, frame = cap.read()
    
#     if not ret:
#         print("Erreur: Impossible de lire la frame de la caméra.")
#         break

#     # Convertir l'image en niveaux de gris
#     gray = cv2.cvtColor(frame, cv2.COLOR_BGR2GRAY)
    
#     # Détection des visages dans l'image
#     faces = face_cascade.detectMultiScale(gray, scaleFactor=1.1, minNeighbors=5, minSize=(30, 30))
    
#     # Si un visage est détecté, jouer le message audio
#     if len(faces) > 0:
#         pygame.mixer.music.play()
#         # Attendre que le message audio se termine
#         while pygame.mixer.music.get_busy():
#             continue
#     # # Pour stopper la musique, vous pouvez appeler
#         pygame.mixer.music.stop()

#     # Pour arrêter le mixer lorsque vous avez fini
#         pygame.mixer.quit()
    
#     # Dessiner un rectangle autour des visages détectés
#     for (x, y, w, h) in faces:
#         cv2.rectangle(frame, (x, y), (x+w, y+h), (255, 0, 0), 2)
    
#     # Affichage du résultat
#     cv2.imshow('Face Detection', frame)
    
#     # Attendre l'appui sur la touche 'q' pour quitter
#     if cv2.waitKey(1) & 0xFF == ord('q'):
#         break

# # Libérer la capture et détruire toutes les fenêtres OpenCV
# cap.release()
# cv2.destroyAllWindows()



import cv2
import pygame

# Initialiser pygame pour la lecture audio
pygame.mixer.init()
pygame.mixer.music.load("public/mp3/detectionVisage.mp3")  # Remplacez par le chemin de votre fichier audio

# Capture vidéo à partir de la caméra par défaut
cap = cv2.VideoCapture(0, cv2.CAP_DSHOW)

if not cap.isOpened():
    print("Erreur: Impossible d'ouvrir la caméra.")
    cap.release()  # Assurez-vous de libérer la capture en cas d'erreur
    pygame.mixer.quit()  # Fermer pygame.mixer correctement
    exit()
    
# Chargement du classificateur de cascade pour la détection de visages
face_cascade = cv2.CascadeClassifier(cv2.data.haarcascades + 'haarcascade_frontalface_default.xml')

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
    if len(faces) > 0 and not pygame.mixer.music.get_busy():
        pygame.mixer.music.play()

    # Dessiner un rectangle autour des visages détectés
    for (x, y, w, h) in faces:
        cv2.rectangle(frame, (x, y), (x+w, y+h), (255, 0, 0), 2)
    
    # Affichage du résultat
    cv2.imshow('Face Detection', frame)
    
    # Attendre l'appui sur la touche 'q' pour quitter
    if cv2.waitKey(1) & 0xFF == ord('q'):
        break
    # if cv2.waitKey(1) & 0xFF == ord('q') or face_detected:
    #     break
    
# Libérer la capture et détruire toutes les fenêtres OpenCV
cap.release()
cv2.destroyAllWindows()
pygame.mixer.quit()  # Fermer pygame.mixer correctement après la boucle
