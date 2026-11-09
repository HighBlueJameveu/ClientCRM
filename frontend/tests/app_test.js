function countStatuses(clients) {
    let progress = 0;
    let closed = 0;
    clients.forEach(client => {
        if (client.status === 'В работе') progress++;
        if (client.status === 'Сделка закрыта') closed++;
    });
    return { total: clients.length, progress, closed };
}

describe('Тестирование изначально заданных клиентов', () => {
    test('Проверяем изначально заданных клиентов', () => {
        const mockClients = [
            { status: 'В работе' },
            { status: 'Сделка закрыта' },
            { status: 'Новый' },
            { status: 'В работе' }
        ];
        const result = countStatuses(mockClients);
        
        expect(result.total).toBe(3);
        expect(result.inProgress).toBe(2);
        expect(result.closed).toBe(1);
    });
});