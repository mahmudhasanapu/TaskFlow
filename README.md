## 🔄 Workflow

```mermaid
flowchart TD

A[User opens Vue Frontend] --> B[Login / Register]
B -->|POST /api/register or /api/login| C[Laravel Backend - Auth Controller]
C -->|Validates + returns token| D[Frontend stores token]

D --> E[User Dashboard - Task List]
E -->|GET /api/tasks| F[Backend - Task Controller -> Database]
F -->|Returns JSON task list| E

E --> G[Create Task]
G -->|POST /api/tasks| F

E --> H[Update Task]
H -->|PUT /api/tasks/{id}| F

E --> I[Delete Task]
I -->|DELETE /api/tasks/{id}| F

F -->|Updated data| E
