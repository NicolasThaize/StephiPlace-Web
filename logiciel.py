#Import de toutes les bibliothèques 
import tkinter 
from tkinter import *
from tkinter import ttk
import tkinter.messagebox as MessageBox
import mysql.connector as mysql



#Connexion a la base 
conn = mysql.connect(host="localhost",user="root", passwd="root",database="bddsite")

#Creation du curseur
c = conn.cursor()

#Creation de la fenetre principale
schedGraphics = tkinter 
root = schedGraphics.Tk() 

root.title("Stephi Place") 
universal_height = 350

nb = ttk.Notebook(root) 
        
# 1ere page (connexion)
Connexion = ttk.Frame(nb, width= 300,height = universal_height) 
# 2eme page (gestion des bien)
Fenetrebien = ttk.Frame(nb,width = 300,height = universal_height) 


##################################################################################

#Déclaration variable pour  la rendre globale plus tard ( ne pas tenir compte )
session = c.fetchone()
query_label=Label(Fenetrebien)
btn_destruction=Button(Fenetrebien)
proprietaire_output = ''
v_id_bien = ''
titre = ''
description = ''
type = ''
superficie = ''
surface_habitable = ''
nbr_piece = ''
prix = ''
date_ajout = ''
code_postal = ''
ville = ''
adresse = ''

##################################################################################

nb.add(Connexion, text='Connexion') 
nb.add(Fenetrebien, text='Editer un bien') 
nb.grid(column=0) 


#------------------------------------------------------------------------------------------#
#Fonctions 

# Fonction de création d'un bien
def infosbien():
    #Déclaration des variables de récupération
    v_titre = titre.get()
    v_description = description.get()
    v_type = type.get()
    v_superficie = superficie.get()
    v_surface_habitable = surface_habitable.get()
    v_nbr_piece = nbr_piece.get()
    v_prix = prix.get()
    v_date_ajout = date_ajout.get()
    v_code_postal = code_postal.get()
    v_ville = ville.get()
    v_adresse = adresse.get()


    #Petite sécurité
    if (v_titre=="" or v_type=="" or v_superficie=="" or v_surface_habitable=="" or v_nbr_piece=="" or v_prix=="" or v_date_ajout=="" or v_code_postal=="" or v_ville=="" or v_adresse==""):
        MessageBox.showinfo("Erreur !","Veuillez completer tous les champs")

    #Si non authentifié
    elif (session is None):
            MessageBox.showinfo("Erreur !","Veuillez vous identifier")
            
    else:
        #Connexion a la base 
        conn = mysql.connect(host="localhost",user="root", passwd="root",database="bddsite")

        #Creation du curseur
        c = conn.cursor()

        #Insertion dans la table  
        mysql_insertion = """INSERT INTO biens (titre,description, type, superficie, surface_habitable, nbr_piece, prix, date_ajout, code_postal, ville, adresse) 
                        VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s) """

        record_tuple = (v_titre,v_description,v_type,v_superficie,v_surface_habitable,v_nbr_piece,v_prix,v_date_ajout,v_code_postal,v_ville,v_adresse)

        c.execute(mysql_insertion,record_tuple)
                
        #Commit des changements
        conn.commit()
        MessageBox.showinfo("Bravo !","Injection des données réussie")
        #Fermeture de la connexion
        conn.close()

        #Vider les input
        titre.delete(0,END)
        description.delete(0,END)
        type.delete(0,END)
        superficie.delete(0,END)
        surface_habitable.delete(0,END)
        nbr_piece.delete(0,END)
        prix.delete(0,END)
        date_ajout.delete(0,END)
        code_postal.delete(0,END)
        ville.delete(0,END)
        adresse.delete(0,END)
    

#Fonction de recherche par ID
def rechercher():

    global query_label
    v_id_bien = id_bien.get()

    

    #Petite sécurité
    try:
        #Destruction du display précédent, permet d'éviter l'overwriting en cas de deuxieme recherche, et évite de créer un bouton juste pour effacer le display
        query_label.destroy()

        #Si champ vide 
        if (v_id_bien==""):
            MessageBox.showinfo("Erreur !","Veuillez completer le champ")

        #Si non identifié
        elif (session is None):
            MessageBox.showinfo("Erreur !","Veuillez vous identifier")

        else:
            
            #Connexion a la base 
            conn = mysql.connect(host="localhost",user="root", passwd="root",database="bddsite")

            #Creation du curseur
            c = conn.cursor()

            #Requete vers la base 
            c.execute("SELECT * FROM biens WHERE id_bien = " + v_id_bien)
            records = c.fetchall()
            #print(records)     output console 
            print_records = ''
            proprietaire_output=''
            
            #Fonction de récupération des données
            for record in records[0]:
                print_records += str(record) + "\n"


            #Display pseudo
            proprietaire = Label(Fenetrebien,text=str(proprietaire_output),justify=LEFT)
            proprietaire.grid(column=1,row=1)

            #Display data bien
            query_label = Label(Fenetrebien, text=print_records, justify=LEFT)
            query_label.grid(row=17, column = 1,columnspan=2,pady=(20,0))

            #Commit des changements
            conn.commit()

            #Fermeture de la connexion
            conn.close()

    except(IndexError):
        MessageBox.showinfo("Erreur","Le bien n'existe pas, veuillez entrer un ID valide")

#Fonction d'affichage des biens dans les barres entry
def Edition():
    

    global proprietaire_output,v_id_bien

    v_id_bien = id_bien.get()

    #Connexion a la base 
    conn = mysql.connect(host="localhost",user="root", passwd="root",database="bddsite")

    #Creation du curseur
    c = conn.cursor()

    #Requete vers la base 
    c.execute("SELECT * FROM biens WHERE id_bien = " + v_id_bien)
    records = c.fetchall()
    #print(records)     output console , ne pas prendre en commpte 
    proprietaire_output='' 

    #Fonction d'affichage des valeurs dans les champs entry pour édition
    for record in records:
        
        proprietaire_output += str(record[1])
        titre.insert(0,record[2])
        description.insert(0,record[3])
        type.insert(0,record[4])
        superficie.insert(0,record[5])
        surface_habitable.insert(0,record[6])
        nbr_piece.insert(0,record[7])
        prix.insert(0,record[8])
        date_ajout.insert(0,record[10])
        adresse.insert(0,record[11])
        code_postal.insert(0,record[12])
        ville.insert(0,record[13])


        #Commit des changements
        conn.commit()

        #Fermeture de la connexion
        conn.close()

#Fonction permettant d'enregister les valeurs des champs sur un bien existant
def Sauvegarde():
    global titre, description, type, superficie, surface_habitable, nbr_piece, prix,  date_ajout, code_postal, ville, adresse

    #Déclaration des variables de récupération
    v_titre = titre.get()
    v_description = description.get()
    v_type = type.get()
    v_superficie = superficie.get()
    v_surface_habitable = surface_habitable.get()
    v_nbr_piece = nbr_piece.get()
    v_prix = prix.get()
    v_date_ajout = date_ajout.get()
    v_code_postal = code_postal.get()
    v_ville = ville.get()
    v_adresse = adresse.get()
    v_id_bien = id_bien.get()
    
    #Si champs vides
    if (v_titre=="" or v_type=="" or v_superficie=="" or v_surface_habitable=="" or v_nbr_piece=="" or v_prix=="" or v_date_ajout=="" or v_code_postal=="" or v_ville=="" or v_adresse==""):
        MessageBox.showinfo("Erreur !","Veuillez completer tous les champs")

    #Si non authentifié
    elif (session is None):
            MessageBox.showinfo("Erreur !","Veuillez vous identifier")
            
    else:
        #Sécurité approximative 
        try:
            #Connexion a la base 
            conn = mysql.connect(host="localhost",user="root", passwd="root",database="bddsite")

            #Creation du curseur
            c = conn.cursor()

            #Requete vers la base 
            mysql_update = """UPDATE biens SET  
            titre = %s,
            description = %s, 
            type = %s,
            superficie = %s, 
            surface_habitable = %s, 
            nbr_piece = %s, 
            prix = %s, 
            date_ajout = %s, 
            code_postal = %s, 
            ville = %s, 
            adresse = %s 
            WHERE id_bien = %s"""
            
            variables_entry = (v_titre,v_description,v_type,v_superficie,v_surface_habitable,v_nbr_piece,v_prix,v_date_ajout,v_code_postal,v_ville,v_adresse,v_id_bien)

            c.execute(mysql_update,variables_entry)
            #Commit des changements
            conn.commit()
            #Fermeture de la connexion
            conn.close()
            MessageBox.showinfo("Réussite","Mise a jour réussie ! ")

            #Vider les input
            titre.delete(0,END)
            description.delete(0,END)
            type.delete(0,END)
            superficie.delete(0,END)
            surface_habitable.delete(0,END)
            nbr_piece.delete(0,END)
            prix.delete(0,END)
            date_ajout.delete(0,END)
            code_postal.delete(0,END)
            ville.delete(0,END)
            adresse.delete(0,END)
        
        except():
            MessageBox.showinfo("Données invalides","Veuillez rentrer des données compatibles")


#Fonction de supression par ID 
def Suppression():
    global btn_destruction
    v_id_bien = id_bien.get()

    if (v_id_bien==""):
            MessageBox.showinfo("Erreur !","Veuillez completer le champ")

    #Si non identifié
    elif (session is None):
        MessageBox.showinfo("Erreur !","Veuillez vous identifier")

    else:
    
        #Connexion a la base 
        conn = mysql.connect(host="localhost",user="root", passwd="root",database="bddsite")

        #Creation du curseur
        c = conn.cursor()

        #Requete vers la base 
        c.execute("DELETE FROM biens WHERE id_bien = " + v_id_bien)
        
        #Destruction du display précédent, permet d'éviter l'overwriting en cas de deuxieme recherche, et évite de créer un bouton juste pour effacer le display
        query_label.destroy()

        #Commit des changements
        conn.commit()

        #Fermeture de la connexion
        conn.close()
        MessageBox.showinfo("Réussite","Suppression du bien effectuée avec succès")

#Fonction + fenetre  d'enregistrement
def register():
    def save_register():

        #Déclaration des variables de récupération
        v_pseudo = pseudo.get()
        v_mdp = mdp.get()
        v_prenom = prenom.get()
        v_nom = nom.get()
        v_mail = mail.get()
        v_tel = tel.get()
        v_date = date.get() 
        v_adresse = adresse.get()
        v_code_postal = code_postal.get()
        v_ville = ville.get()

        if (v_pseudo=="" or  v_mdp=="" or v_prenom=="" or v_nom=="" or v_mail=="" or v_date=="" or v_tel=="" 
        or v=="" or v_adresse=="" or v_code_postal=="" or v_ville==""):
            MessageBox.showinfo("Erreur !","Veuillez completer tous les champs")

        else:
            #Connexion a la base 
            conn = mysql.connect(host="localhost",user="root", passwd="root",database="bddsite")

            #Creation du curseur
            c = conn.cursor()

            mysql_insertion = """INSERT INTO utilisateurs(pseudonyme,mdp,prenom,nom,mail,telephone,date_naissance,categorie,adresse,code_postal,ville)
                              VALUES(%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)"""

            record_tuple = (v_pseudo,v_mdp,v_prenom,v_nom,v_mail,v_tel,v_date,str(v),v_adresse,v_code_postal,v_ville)

            c.execute(mysql_insertion,record_tuple)

            #Commit des changements
            conn.commit()
            MessageBox.showinfo("Bravo !","Bienvenue, vous êtes maintenant enregistré ! ")
            #Fermeture de la connexion
            conn.close()

            #Vider les input
            pseudo.delete(0,END)
            mdp.delete(0,END)
            prenom.delete(0,END)
            nom.delete(0,END)
            mail.delete(0,END)
            tel.delete(0,END)
            date.delete(0,END)
            cat.deselect()
            code_postal.delete(0,END)
            ville.delete(0,END)
            adresse.delete(0,END)

    #-----------------------------------------------------------------------------------#

    #Nouvelle fenetre
    register = Toplevel(root)
    register.title("S'enregistrer")
    register.geometry("300x300")

    #Creation des champs

    txt_pseudo = Label(register, text=" Pseudonyme : ", justify=LEFT)
    pseudo = Entry(register)
    txt_pseudo.grid(column=0, row=0)
    pseudo.grid(column=1, row=0)

    txt_mdp = Label(register, text=" Mot de passe : ", justify=LEFT)
    mdp = Entry(register)
    txt_mdp.grid(column=0, row=1)
    mdp.grid(column=1, row=1)

    txt_prenom = Label(register, text=" Prénom : ", justify=LEFT)
    prenom = Entry(register)
    txt_prenom.grid(column=0, row=2)
    prenom.grid(column=1, row=2)
    
    txt_nom = Label(register, text=" Nom : ", justify=LEFT)
    nom = Entry(register)
    txt_nom.grid(column=0, row=3)
    nom.grid(column=1, row=3)

    txt_mail = Label(register, text=" E-mail : ", justify=LEFT)
    mail = Entry(register)
    txt_mail.grid(column=0, row=4)
    mail.grid(column=1, row=4)

    txt_tel = Label(register, text=" Telephone : ", justify=LEFT)
    tel = Entry(register)
    txt_tel.grid(column=0, row=5)
    tel.grid(column=1, row=5)

    txt_date = Label(register, text=" Date de Naissance : ", justify=LEFT)
    date = Entry(register)
    txt_date.grid(column=0, row=6)
    date.grid(column=1, row=6)

    txt_cat = Label(register, text=" Categorie : ", justify=LEFT)
    txt_cat.grid(column=0,row=7)
    listeOptions = ('Agent', 'Administrateur')
    v = StringVar()
    v.set(listeOptions[0])
    cat = OptionMenu(register, v, *listeOptions)
    cat.grid(column=1,row=7)

    txt_adresse = Label(register, text=" Adresse : ", justify=LEFT)
    adresse = Entry(register)
    txt_adresse.grid(column=0, row=8)
    adresse.grid(column=1, row=8)

    txt_code_postal = Label(register, text=" Code postal : ", justify=LEFT)
    code_postal = Entry(register)
    txt_code_postal.grid(column=0, row=9)
    code_postal.grid(column=1, row=9)

    txt_ville = Label(register, text=" Ville : ", justify=LEFT)
    ville = Entry(register)
    txt_ville.grid(column=0, row=10)
    ville.grid(column=1, row=10,columnspan=1)

    btn_save_register = Button(register, command=save_register,text="Enregistrer")
    btn_save_register.grid(column=0,row=11)
    
#Fonction + fenetre d'identification
def login():
    #Fonction d'identification
    def save_login():
        global session
        v_pseudo = pseudo.get()
        v_mdp = mdp.get()

        if (v_pseudo=="" or v_mdp==""):
            MessageBox.showinfo("Erreur ! ","Veuillez renseigner tous les champs")

        else:    
            #Connexion a la base 
            conn = mysql.connect(host="localhost",user="root", passwd="root",database="bddsite")

            #Creation du curseur
            c = conn.cursor()
            c.execute('SELECT * FROM utilisateurs WHERE pseudonyme = %s AND mdp = %s', (v_pseudo, v_mdp,))
            # Fetch one record and return result
            session = c.fetchone()
            
            #Commit des changements
            conn.commit()
            if session:
                MessageBox.showinfo("Bravo !","Bienvenue, vous êtes maintenant enregistré ! ")
                login.destroy()
            else:
                MessageBox.showinfo("Erreur !", "Identifiants invalides !")
            #Fermeture de la connexion
            conn.close()
       
    #--------------------------------------------------------------------------------------#
    #Nouvelle fenetre
    login = Toplevel(root)
    login.title("S'identifier")
    login.geometry("200x140")

    #Creation des champs            
    display_pseudo = Label(login,text = "Entrez un pseudonyme")
    pseudo = Entry(login)
    display_pseudo.pack()
    pseudo.pack()


    display_mdp = Label(login,text = "Entrez un mot de passe")
    mdp = Entry(login)
    display_mdp.pack()
    mdp.pack()

    btn_login = Button(login,text= "S'identifier",command=save_login)
    btn_login.pack(pady=10)


#--------------------------------------------------------------------------------------#
#Front de la page de connexion


btn_connexion = Button(Connexion,text="S'identifier", command=login)
btn_connexion.pack(ipadx=15,ipady=10,pady=(240,10))

btn_register = Button(Connexion,text="S'enregistrer", command=register)
btn_register.pack(ipadx=10,ipady=10)

#Front de la page d'edition de bien

txt_bien = Label(Fenetrebien, text=' Rechercher un bien : ', justify=LEFT)
id_bien = Entry(Fenetrebien)
btn_bien = Button(Fenetrebien,text='Rechercher', command=rechercher)
txt_bien.grid(column=0,row=0)
id_bien.grid(column=1,row=0)
btn_bien.grid(column=2,row=0)

txt_proprietaire = Label(Fenetrebien, text=" Propriétaire : ", justify=LEFT)
txt_proprietaire.grid(column=0,row=1)

txt_titre = Label(Fenetrebien, text=" Titre : ", justify=LEFT)
titre = Entry(Fenetrebien)
txt_titre.grid(column=0, row=3)
titre.grid(column=1, row=3)


txt_type = Label(Fenetrebien, text=" Type : ", justify=LEFT)
type = Entry(Fenetrebien)
txt_type.grid(column=0, row=4)
type.grid(column=1, row=4)

txt_desc = Label(Fenetrebien, text=" Description : ", justify=LEFT)
description = Entry(Fenetrebien)
txt_desc.grid(column=0, row=5)
description.grid(column=1, row=5)


txt_superficie =  Label(Fenetrebien, text=" Superficie : ", justify=LEFT)
superficie = Entry(Fenetrebien)
txt_superficie.grid(column=0, row=6)
superficie.grid(column=1, row=6)


txt_surface_habitable = Label(Fenetrebien, text=" Surface Habitable : ", justify=LEFT)
surface_habitable = Entry(Fenetrebien)
txt_surface_habitable.grid(column=0, row=7)
surface_habitable.grid(column=1, row=7)


txt_nbr_piece = Label(Fenetrebien, text=" Nombre de pièces : ", justify=LEFT)
nbr_piece = Entry(Fenetrebien)
txt_nbr_piece.grid(column=0, row=8)
nbr_piece.grid(column=1, row=8)


txt_prix = Label(Fenetrebien, text=" Prix : ", justify=LEFT)
prix = Entry(Fenetrebien)
txt_prix.grid(column=0, row=9)
prix.grid(column=1, row=9)


txt_date_ajout = Label(Fenetrebien, text=" Date d'ajout : ", justify=LEFT)
date_ajout = Entry(Fenetrebien)
txt_date_ajout.grid(column=0, row=10)
date_ajout.grid(column=1, row=10)

txt_code_postal = Label(Fenetrebien, text=" Code Postal : ", justify=LEFT)
code_postal = Entry(Fenetrebien)
txt_code_postal.grid(column=0, row=11)
code_postal.grid(column=1, row=11)


txt_ville = Label(Fenetrebien, text=" Ville : ", justify=LEFT)
ville = Entry(Fenetrebien)
txt_ville.grid(column=0, row=12)
ville.grid(column=1, row=12)


txt_adresse = Label(Fenetrebien,justify=LEFT, text=" Adresse : " )
adresse = Entry(Fenetrebien)
txt_adresse.grid(column=0, row=13)
adresse.grid(column=1, row=13)

# Bouton permettant de valider le résultat des champs
btn_validation = Button(Fenetrebien,text='Créer un nouveau bien', command=infosbien)
btn_validation.grid(column=0,row=14,padx=(50,15),pady=10)


# Bouton permettant d'éditer le bien
btn_edition = Button(Fenetrebien,text="Mettre le bien à jour", command=Edition)
btn_edition.grid(column=1,row=14,padx=(0,10))

#Bouton permettant de supprimer un bien 
btn_destruction = Button(Fenetrebien, text="Supprimer le bien", command=Suppression)
btn_destruction.grid(column=2,row=14)

#Bouton de sauvegarde du bien édité
sauvegarde = Button(Fenetrebien, text=" Enregistrer le bien ", command=Sauvegarde)
sauvegarde.grid(column=2,row=18,padx=10)

#Bouton destruction de fenetre
quitter = Button(Fenetrebien, text=" Quitter ", command=root.destroy)
quitter.grid(column=3,row=18)

#Front page édition, partie display
display_id = Label(Fenetrebien, justify=LEFT,
text=
" ID : \n "
" Propriétaire : \n"
" Titre : \n"
" Description : \n"
" Type : \n"
" Superficie : \n"
" Surface Habitable : \n"
" Nombre de Pièces : \n"
" Prix : \n"
" Photos : \n"
" Date d'ajout : \n"
" Adresse : \n"
" Code Postal : \n"
" Ville : \n"
" Etage : \n")
display_id.grid(row=17, column=0,pady=(20,0))



# Lancement de la boucle principale
root.mainloop()

#Commit des changements
conn.commit()

#Fermeture de la connexion
conn.close()

