from fastapi import FastAPI
from fastapi.middleware.cors import CORSMiddleware
from fastapi.staticfiles import StaticFiles
from sqlmodel import Session, select
import os
from .database import init_db, engine
from .models import User
from .core.security import get_password_hash
from .routers import auth, products, projects, accessories, uploads, activities

app = FastAPI(title="Stradip Backend API")

# Configuration CORS
app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"], # À restreindre en production
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

# Montage du dossier uploads pour servir les images
if not os.path.exists("src/backend/uploads"):
    os.makedirs("src/backend/uploads", exist_ok=True)
app.mount("/uploads", StaticFiles(directory="src/backend/uploads"), name="uploads")

def create_admin_user():
    with Session(engine) as session:
        admin = session.exec(select(User).where(User.username == "admin")).first()
        if not admin:
            admin = User(
                username="admin",
                hashed_password=get_password_hash("admin123") # À changer immédiatement !
            )
            session.add(admin)
            session.commit()
            print("Default admin user created: admin / admin123")

@app.on_event("startup")
def on_startup():
    init_db()
    create_admin_user()

@app.get("/")
def read_root():
    return {"message": "Welcome to Stradip Backend API"}

# Inclusion des routers
app.include_router(auth.router, prefix="/api/auth", tags=["Authentication"])
app.include_router(products.router, prefix="/api/products", tags=["Products"])
app.include_router(projects.router, prefix="/api/projects", tags=["Projects"])
app.include_router(accessories.router, prefix="/api/accessories", tags=["Accessories"])
app.include_router(uploads.router, prefix="/api/upload", tags=["Uploads"])
app.include_router(activities.router, prefix="/api/activities", tags=["Activities"])
