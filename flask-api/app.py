from flask import Flask, request, jsonify

# Initialize Flask app
app = Flask(__name__)

@app.route('/process-task', methods=['POST'])
def process_task():
    """
    Endpoint to process a task. This route accepts a POST request with
    a JSON payload containing the task_name and returns a message
    confirming task processing.
    
    :return: JSON response with a confirmation message
    """
    try:
        # Get JSON data from the request
        data = request.get_json()

        # Ensure task_name is provided
        if not data or 'task_name' not in data:
            return jsonify({"error": "Task name is required"}), 400

        # Process the task and generate a response message
        task_name = data.get('task_name')
        response_message = f"Task '{task_name}' has been successfully processed by Python."

        # Return a JSON response with the confirmation message
        return jsonify({"message": response_message}), 200

    except Exception as e:
        # Handle any unexpected exceptions and return a 500 error
        return jsonify({"error": "An error occurred", "details": str(e)}), 500

if __name__ == '__main__':
    # Run the Flask app on port 5000 with debug mode enabled for development
    app.run(port=5000, debug=True)
