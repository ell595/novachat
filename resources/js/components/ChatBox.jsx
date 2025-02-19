import React, { useEffect, useRef, useState } from "react";
import Message from "./Message.jsx";
import MessageInput from "./MessageInput.jsx";

const ChatBox = ({ rootUrl }) => {
    const [messages, setMessages] = useState([]);
    const scroll = useRef();
    
    const userData = document.getElementById('main').getAttribute('data-user');
    const user = JSON.parse(userData);

    const roomData = document.getElementById('main').getAttribute('data-room');
    const room = JSON.parse(roomData);
    const { name, id, code } = room;
    localStorage.setItem("room_code", code);

    const webSocketChannel = 'room_' + id;

    const scrollToBottom = () => {
        scroll.current.scrollIntoView({ behavior: "smooth" });
    };

    const connectWebSocket = () => {
        window.Echo.private(webSocketChannel)
            .listen('.GotMessage', async (e) => {
                await getMessages();
            });
    }

    const getMessages = async () => {
        try {
            const m = await axios.get(`${rootUrl}/messages/room/${id}`);
            setMessages(m.data);
            setTimeout(scrollToBottom, 0);
        } catch (err) {
            console.log(err.message);
        }
    };

    useEffect(() => {
        getMessages();
        connectWebSocket();

        return () => {
            window.Echo.leave(webSocketChannel);
        }
    }, []);

    return (
        <div className="row justify-content-center">
            <div className="col-md-8">
                <div className="card">
                    <div className="card-header">{ name }</div>
                    <div className="card-body"
                         style={{height: "500px", overflowY: "auto"}}>
                        {
                            messages?.map((message) => (
                                <Message key={message.id}
                                         userId={user.id}
                                         message={message}
                                />
                            ))
                        }
                        <span ref={scroll}></span>
                    </div>
                    <div className="card-footer">
                        <MessageInput rootUrl={rootUrl} room_id={id} />
                    </div>
                </div>
            </div>
        </div>
    );
};

export default ChatBox;