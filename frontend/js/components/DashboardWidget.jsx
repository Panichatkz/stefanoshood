function DashboardWidget() {
    const [likes, setLikes] = React.useState(0);
    return (
        <div style={{ background: '#fff', padding: '15px', border: '1px solid #ddd', margin: '15px 0', borderRadius: '5px' }}>
            <h4>🚀 Stefano's Hood Live React Widget</h4>
            <p>Interact with this live component powered by React.js!</p>
            <button onClick={() => setLikes(likes + 1)} style={{ padding: '8px 15px', cursor: 'pointer' }}>
                ❤️ Community Cheers: {likes}
            </button>
        </div>
    );
}

// Mount the React component onto a DOM node if it exists on the page
const rootElement = document.getElementById('react-root');
if (rootElement) {
    const root = ReactDOM.createRoot(rootElement);
    root.render(<DashboardWidget />);
}