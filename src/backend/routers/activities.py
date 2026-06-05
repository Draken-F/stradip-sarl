from typing import List
from fastapi import APIRouter, Depends
from sqlmodel import Session, select
from database import get_session
from models import Activity

router = APIRouter()

@router.get("/", response_model=List[Activity])
def read_activities(limit: int = 10, db: Session = Depends(get_session)):
    return db.exec(select(Activity).order_by(Activity.timestamp.desc()).limit(limit)).all()

def log_activity(action: str, target_type: str, target_name: str, icon: str, db: Session):
    activity = Activity(
        action=action,
        target_type=target_type,
        target_name=target_name,
        icon=icon
    )
    db.add(activity)
    db.commit()
