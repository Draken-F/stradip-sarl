from typing import List, Optional
from sqlmodel import Field, Relationship, SQLModel
from datetime import datetime

# --- TABLES DE LIAISON ---

class RealisationProduitLink(SQLModel, table=True):
    section_id: Optional[int] = Field(default=None, foreign_key="realisationsection.id", primary_key=True)
    product_id: Optional[int] = Field(default=None, foreign_key="product.id", primary_key=True)

# --- MODÈLES ---

class User(SQLModel, table=True):
    id: Optional[int] = Field(default=None, primary_key=True)
    username: str = Field(index=True, unique=True)
    hashed_password: str

class Category(SQLModel, table=True):
    id: Optional[int] = Field(default=None, primary_key=True)
    nom_matiere: str = Field(index=True)
    
    products: List["Product"] = Relationship(back_populates="category")

class Product(SQLModel, table=True):
    id: Optional[int] = Field(default=None, primary_key=True)
    nom: str = Field(index=True)
    reference: str = Field(unique=True, index=True)
    dimension: str
    type_pose: str # Sol, Mur, etc.
    piece: str # Salon, SDB, etc.
    couleur: Optional[str] = None
    style: str = "Standard"
    image_url: str
    description: Optional[str] = None
    date_ajout: datetime = Field(default_factory=datetime.utcnow)

    category_id: Optional[int] = Field(default=None, foreign_key="category.id")
    category: Optional[Category] = Relationship(back_populates="products")
    
    sections: List["RealisationSection"] = Relationship(
        back_populates="products", link_model=RealisationProduitLink
    )

class Accessory(SQLModel, table=True):
    id: Optional[int] = Field(default=None, primary_key=True)
    nom: str = Field(index=True)
    categorie_acc: str # Pose, Outil, etc.
    image_url: str
    description: Optional[str] = None
    usage: Optional[str] = None
    conditionnement: Optional[str] = None
    stock: bool = True

class Realisation(SQLModel, table=True):
    id: Optional[int] = Field(default=None, primary_key=True)
    nom: str = Field(index=True)
    ville: str
    image_globale: str
    introduction: Optional[str] = None
    date_ajout: datetime = Field(default_factory=datetime.utcnow)
    
    sections: List["RealisationSection"] = Relationship(back_populates="realisation")

class RealisationSection(SQLModel, table=True):
    id: Optional[int] = Field(default=None, primary_key=True)
    titre_piece: str
    description: Optional[str] = None
    image_ambiance: str
    ordre_affichage: int = 0
    
    realisation_id: Optional[int] = Field(default=None, foreign_key="realisation.id")
    realisation: Optional[Realisation] = Relationship(back_populates="sections")
    
    photos: List["RealisationSectionPhoto"] = Relationship(back_populates="section")
    products: List["Product"] = Relationship(
        back_populates="sections", link_model=RealisationProduitLink
    )

class RealisationSectionPhoto(SQLModel, table=True):
    id: Optional[int] = Field(default=None, primary_key=True)
    image_url: str
    ordre: int = 0
    
    section_id: Optional[int] = Field(default=None, foreign_key="realisationsection.id")
    section: Optional[RealisationSection] = Relationship(back_populates="photos")

class Activity(SQLModel, table=True):
    id: Optional[int] = Field(default=None, primary_key=True)
    action: str # "Création", "Modification", "Suppression"
    target_type: str # "Produit", "Projet", "Accessoire"
    target_name: str
    timestamp: datetime = Field(default_factory=datetime.utcnow)
    icon: str = "📝"
