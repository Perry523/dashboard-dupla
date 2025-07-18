
export function receiveStatusResume(statusType: string): number {
    const data = fillStatusResume()

    if (statusType === 'PIXES') {
        return data.Pixes; 
    }else if (statusType === 'USERS') {
        return data.Users; 
    }else if (statusType === 'MSELAPSED') {
        return data.MsElapsed;
    }
    return 0;
}

const fillStatusResume = ()  => {
    return {Pixes: 40, Users: 10, MsElapsed: 3600};
}

export function stylizeStatusType(statusType: string): string {
    if (statusType === 'PIXES') {
        return 'Pixes';
    } else if (statusType === 'USERS') {
        return 'Usuários';
    } else if (statusType === 'MSELAPSED') {
        return 'Tempo médio';
    }
    return '';
}