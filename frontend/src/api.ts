import type { TokenData, Algorithm } from './types';

const API_URL = 'http://localhost:8000';

export async function countTokens(
  text: string,
  model: Algorithm
): Promise<TokenData> {
  const response = await fetch(`${API_URL}/count`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify({ text, model }),
  });

  if (!response.ok) {
    const error = await response.json();
    throw new Error(error.error || 'Failed to count tokens');
  }

  return response.json();
}
