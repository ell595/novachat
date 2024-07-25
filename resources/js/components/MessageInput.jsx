import React, { useState } from "react";
import $ from 'jquery';

const MessageInput = ({ rootUrl, room_id }) => {
    const [message, setMessage] = useState("");

    const messageRequest = async (text, room_id) => {
        try {
            const response = await axios.post(`${rootUrl}/message`, {
                text, room_id,
            });
            console.log(response);
        } catch (err) {
            console.log(err.message);
        }
    };

    const sendMessage = (e) => {
        e.preventDefault();
        if (message.trim() === "") {
            alert("Please enter a message!");
            return;
        }

        messageRequest(message, room_id);
        setMessage("");
    };

    $(document).ready(function() {
        $('#messageInput').off("keydown", "input").on("keydown", "input", function(e) {
            if (e.which == 13 && !e.shiftKey) {
                $(this).closest(".input-group").find("button").click();
            }
        });




        $(document)
  .one('focus.textarea', '.autoExpand', function() {
    var savedValue = this.value
    this.value = ''
    this.baseScrollHeight = this.scrollHeight
    this.value = savedValue
  })
  .on('input.textarea', '.autoExpand', function() {
    var rows, minRows = this.getAttribute('data-min-rows') | 0;
    this.rows = minRows
    rows = Math.floor((this.scrollHeight - this.baseScrollHeight) / 16)
    this.rows = minRows + rows
  });
    });

    return (
        <div className="input-group" id="messageInput">
            <input onChange={(e) => setMessage(e.target.value)}
                   autoComplete="off"
                   //type="text"
                   className="form-control"
                   placeholder="Message..."
                   value={message}
            />
            
            <div className="input-group-append">
                <button onClick={(e) => sendMessage(e)}
                        className="btn btn-success"
                        type="button">Send</button>
            </div>
        </div>
    );
};

export default MessageInput;