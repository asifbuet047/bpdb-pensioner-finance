import { useState } from "react";

export default function Counter() {
    const [count, setCount] = useState(0);

    return (
        <div className="flex items-center justify-center bg-gray-100">
            <div className="rounded-xl bg-white p-6 shadow-md w-64 text-center">
                <p className="text-lg font-semibold text-gray-700 mb-4">
                    Count: <span className="text-blue-600">{count}</span>
                </p>

                <div className="flex justify-center gap-4">
                    <button
                        onClick={() => setCount(count + 1)}
                        className="px-4 py-2 rounded-lg bg-blue-500 text-white font-medium hover:bg-blue-600 transition"
                    >
                        +
                    </button>

                    <button
                        onClick={() => setCount(count - 1)}
                        className="px-4 py-2 rounded-lg bg-red-500 text-white font-medium hover:bg-red-600 transition"
                    >
                        -
                    </button>
                </div>
            </div>
        </div>
    );
}
