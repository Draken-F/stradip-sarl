import os

class Settings:
    PROJECT_NAME: str = "Stradip Backend"
    SECRET_KEY: str = os.getenv("SECRET_KEY", "your-super-secret-key-change-me")
    ALGORITHM: str = "HS256"
    ACCESS_TOKEN_EXPIRE_MINUTES: int = 60 * 24 * 7  # 7 days

    DATABASE_URL: str = os.getenv("DATABASE_URL", "postgresql://neondb_owner:npg_4SQorgImfK8s@ep-calm-heart-agdiiycm-pooler.c-2.eu-central-1.aws.neon.tech/neondb")

settings = Settings()
