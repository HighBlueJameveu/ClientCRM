async function loadClients() {
    try {
        const response = await fetch('/api/');
        const clients = await response.json();
        
        const tbody = document.getElementById('clientsTableBody');
        tbody.innerHTML = '';

        clients.forEach(client => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${client.id}</td>
                <td>${client.full_name}</td>
                <td>${client.phone}</td>
                <td>${client.email}</td>
                <td>${client.service_type}</td>
                <td>${client.status}</td>
                <td><button class="delete-btn" data-id="${client.id}">Удалить</button></td>
            `;
            tbody.appendChild(tr);
        });
    } catch (error) {
        console.error('Ошибка при загрузке:', error);
    }
}

document.getElementById('clientForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    const newClient = {
        full_name: document.getElementById('full_name').value,
        phone: document.getElementById('phone').value,
        email: document.getElementById('email').value,
        service_type: document.getElementById('service_type').value,
        status: document.getElementById('status').value
    };

    try {
        const response = await fetch('/api/', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(newClient)
        });

        if (response.ok) {
            document.getElementById('clientForm').reset();
            loadClients();
        }
    } catch (error) {
        console.error('Ошибка при сохранении:', error);
    }
});

document.getElementById('clientsTableBody').addEventListener('click', async (e) => {
    if (e.target.classList.contains('delete-btn')) {
        const clientId = e.target.getAttribute('data-id');

        if (confirm(`Вы уверены, что хотите удалить клиента с ID ${clientId}?`)) {
            try {
                const response = await fetch(`/api/?id=${clientId}`, {
                    method: 'DELETE'
                });

                if (response.ok) {
                    loadClients();
                }
            } catch (error) {
                console.error('Ошибка при удалении:', error);
            }
        }
    }
});

document.addEventListener('DOMContentLoaded', loadClients);