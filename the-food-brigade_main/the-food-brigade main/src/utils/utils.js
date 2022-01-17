import * as jquery from "./jquery-3.5.1.min.js";

export function htmlGet(url) {
	return new Promise((resolve, reject) => {
		$.ajax({
			type: 'GET',
			url: url,
			crossdomain: true,
			success: (response) => resolve(response),
			error: (response) => reject(response)
		});
	});
}

export function htmlPost(url, data) {
    return new Promise((resolve, reject) => {
        $.ajax({
            type: 'POST',
            url: url,
            crossdomain: true,
            data: JSON.stringify(data),
            success: (response) => resolve(response),
            error: (response) => reject(response)
        });
    });
}
