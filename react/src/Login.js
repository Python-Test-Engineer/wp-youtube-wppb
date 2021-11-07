import { useState } from 'react';

export default function Login() {
	const [username, setUsername] = useState('');
	const [password, setPassword] = useState('');
	const [user, setUser] = useState(null);

	// console.log('Login.js');

	const handleSubmit = (event) => {
		event.preventDefault();
		const userData = {
			username,
			password,
		};
		setUser(userData);
		setUsername('');
		setPassword('');
	};

	return (
		<div style={{ textAlign: 'center' }}>
			<h2>LOGIN</h2>
			<br />
			<form
				style={{
					display: 'grid',
					alignItems: 'center',
					justifyItems: 'center',
				}}
				onSubmit={handleSubmit}>
				<input
					type='text'
					placeholder='Username'
					onChange={(event) => setUsername(event.target.value)}
					value={username}
				/>
				<input
					type='text'
					placeholder='Password'
					onChange={(event) => setPassword(event.target.value)}
					value={password}
				/>
				<button
					type='submit'
					style={{
						outline: 'none',
						borderRadius: '10px',
						color: 'white',
						background: 'purple',
						fontSize: '25px',
						padding: '5px 10px',
						letterSpacing: '2px',
					}}>
					Submit
				</button>
				<br />
				<div> {user && <div style={{ fontSize: '25px' }}>{JSON.stringify(user, null, 2)}</div>}</div>
			</form>
		</div>
	);
}
