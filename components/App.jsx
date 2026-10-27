import React, { useState, useEffect } from 'react';
import { createRoot } from 'react-dom/client';

function MessageBoard({ recipient }) {
    const [messages, setMessages] = useState([]);
    const [text, setText] = useState('');
    const [pm, setPm] = useState('0');

    const fetchMessages = async () => {
        try {
            const res = await fetch(`api.php?action=get_messages&view=${recipient}`);
            const data = await res.json();
            setMessages(data);
        } catch (err) {
            console.error("Failed to load messages", err);
        }
    };

    useEffect(() => {
        fetchMessages();
        const interval = setInterval(fetchMessages, 5000); // Poll every 5s for live updates
        return () => clearInterval(interval);
    }, [recipient]);

    const handleSubmit = async (e) => {
        e.preventDefault();
        if (!text.trim()) return;

        const formData = new URLSearchParams();
        formData.append('text', text);
        formData.append('recip', recipient);
        formData.append('pm', pm);

        await fetch('api.php?action=post_message', {
            method: 'POST',
            body: formData
        });

        setText('');
        fetchMessages();
    };

    return (
        <div className="react-message-board">
            <h3>Live Message Feed</h3>
            <form onSubmit={handleSubmit}>
                <div>
                    <label>
                        <input type="radio" value="0" checked={pm === '0'} onChange={(e) => setPm(e.target.value)} /> Public
                    </label>
                    <label style={{ marginLeft: '15px' }}>
                        <input type="radio" value="1" checked={pm === '1'} onChange={(e) => setPm(e.target.value)} /> Private (Whisper)
                    </label>
                </div>
                <textarea 
                    value={text} 
                    onChange={(e) => setText(e.target.value)} 
                    placeholder="Type a message using React..." 
                    rows="3"
                    style={{ width: '100%', marginTop: '10px' }}
                />
                <button type="submit" style={{ marginTop: '5px' }}>Post via React</button>
            </form>

            <div className="message-list" style={{ marginTop: '20px' }}>
                {messages.map((msg) => (
                    <div key={msg.id} style={{ borderBottom: '1px solid #ddd', padding: '8px 0' }}>
                        <strong>{msg.auth}</strong> {msg.pm == '1' ? <span className="whisper">(whispered):</span> : 'wrote:'}
                        <p>{msg.message}</p>
                        <small>{new Date(msg.time * 1000).toLocaleString()}</small>
                    </div>
                ))}
            </div>
        </div>
    );
}

// Mount MessageBoard to DOM if container exists
const feedContainer = document.getElementById('react-feed-root');
if (feedContainer) {
    const root = createRoot(feedContainer);
    root.render(<MessageBoard recipient={feedContainer.dataset.recipient} />);
}


function App() {
    const [count, setCount] = useState(0);

    return (
        <div style={{ padding: '15px', background: '#eef2f5', border: '1px dashed #333', margin: '20px 0', textAlign: 'center' }}>
            <h3>🚀 React is Alive in Stefano's Hood!</h3>
            <p>Current Counter Value: <strong>{count}</strong></p>
            <button 
                onClick={() => setCount(count + 1)}
                style={{ padding: '8px 16px', background: '#eb8', border: 'none', cursor: 'pointer', fontWeight: 'bold' }}
            >
                Click to Increment
            </button>
        </div>
    );
}

// Mount App counter component to DOM if container exists
const appContainer = document.getElementById('react-root');
if (appContainer) {
    const root = createRoot(appContainer);
    root.render(<App />);
}