from flask import Flask, request, jsonify

app = Flask(__name__)

@app.route('/process-task', methods=['POST'])
def process_task():
    data = request.json
    task_name = data.get('task_name')
    response_message = f"Task '{task_name}' has been successfully processed by Python."
    return jsonify({"message": response_message})

if __name__ == '__main__':
    app.run(port=5000, debug=True)
