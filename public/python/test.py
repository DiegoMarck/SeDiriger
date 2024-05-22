import pygame

# Initialiser pygame pour la lecture audio
pygame.mixer.init()
try:
    pygame.mixer.music.load("public/mp3/detectionVisage.mp3")
    print("Fichier audio chargé avec succès.")
    pygame.mixer.music.play()
    print("Lecture du fichier audio...")
    while pygame.mixer.music.get_busy():
        continue
    print("Lecture terminée.")
except pygame.error as e:
    print(f"Erreur lors de la lecture du fichier audio: {e}")
finally:
    pygame.mixer.quit()
