<?php

namespace App\Http\Middleware;

use Closure;
use Throwable;
use Illuminate\Http\Request;
use App\Contracts\MassMailerKeyContract;
use App\Http\Requests\MassMailerRequest;
use App\Exceptions\InvalidAppKeyException;

class CheckMassMailerKey
{
    protected MassMailerKeyContract $massMailerKeyCheck;

    public function __construct(MassMailerKeyContract $massMailerKeyCheck)
    {
        $this->massMailerKeyCheck = $massMailerKeyCheck;
    }

    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $authHeader = $request->header('Authorization', null);

        if ($authHeader === null) {
            return unauthorized(['message' => 'Please provide a valid Mass Mailer key']);
        }

        $typeAndToken = explode(' ', $authHeader);

        if (count($typeAndToken) !== 2 || strcmp('massmailer', strtolower($typeAndToken[0])) !== 0) {
            return badRequest(
                ['message' => 'Authorization header is not in correct format (Expected: MassMailer token)']
            );
        }


        try {
            $application = $this->massMailerKeyCheck->verifyKey($typeAndToken[1]);

            $massMailerRequest = MassMailerRequest::createFrom($request);

            $massMailerRequest->setApplication($application);

            return $next($massMailerRequest);
        } catch (InvalidAppKeyException $e) {
            return unprocessableEntity(['message' => $e->getMessage()]);
        } catch (Throwable $e) {
            return notFound(['message' => 'App key is not found']);
        }
    }
}
