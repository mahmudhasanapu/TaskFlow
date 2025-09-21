## 🔄 Workflow

User (Frontend - Vue)
        |
        v
[ Login / Register ]
        |
        v
Laravel Backend (Auth Controller)
        |
        v
Database (User stored)

------------------------------------------

After login:

User Dashboard (Vue)
        |
        v
Request --> [ Laravel API (Task Controller) ] --> Database
        |                |       ^
        |                v       |
        |<--- JSON Response -----|

Actions:
- Create Task   -> POST /api/tasks
- View Tasks    -> GET /api/tasks
- Update Task   -> PUT /api/tasks/{id}
- Delete Task   -> DELETE /api/tasks/{id}

------------------------------------------

Result:
- Frontend updates the UI with the latest data
- Tasks are stored in database via Laravel API
