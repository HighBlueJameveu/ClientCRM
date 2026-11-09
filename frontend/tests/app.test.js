function countStatuses(clients) {
    let inProgress = 0;
    let closed = 0;
    clients.forEach(client => {
        if (client.status === 'В работе') inProgress++;
        if (client.status === 'Сделка закрыта') closed++;
    });
    return { total: clients.length, inProgress, closed };
}

describe('Тестирование изначально заданных клиентов', () => {
    test('Проверяем изначально заданных клиентов', () => {
        const mockClients = [
            { full_name: 'Иванов', status: 'В работе' },
            { full_name: 'Петрова', status: 'Новый' },
            { full_name: 'Сидоров', status: 'Сделка закрыта' }
        ];
        const result = countStatuses(mockClients);
        
        expect(result.total).toBe(3);
        expect(result.inProgress).toBe(1);
        expect(result.closed).toBe(1);
    });
});